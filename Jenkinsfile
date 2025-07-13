pipeline {
    agent any

    environment {
        COMPOSE_FILE = 'docker-compose.yml'
        APP_CONTAINER = 'backend-note-list'
        MYSQL_CONTAINER = 'mysql-note-list'
    }

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/andreirhamni09/backend-note-list.git', branch: 'master'
            }
        }

        stage('Ensure MySQL is Running') {
            steps {
                script {
                    def mysqlRunning = sh(
                        script: 'docker ps --filter "name=mysql-note-list" --filter "status=running" --format "{{.Names}}"',
                        returnStdout: true
                    ).trim()

                    if (mysqlRunning == '') {
                        echo "MySQL container is not running. Building and starting MySQL..."
                        sh 'docker-compose build mysql'
                        sh 'docker-compose up -d mysql'
                        sh 'sleep 10'
                    } else {
                        echo "MySQL container is already running."
                    }
                }
            }
        }

        stage('Rebuild App and Webserver Only') {
            steps {
                sh 'docker-compose rm -fs app webserver || true'
                sh 'docker-compose build --no-cache app webserver'
                sh 'docker-compose up -d app webserver'
            }
        }

        stage('Remove .env') {
            steps {
                sh 'rm -f app/.env'
            }
        }

        stage('Prepare .env') {
            steps {
                sh 'cp -n app/.env.example app/.env || true'
                sh 'chmod 777 app/.env'
            }
        }

        stage('Run Laravel Migration') {
            steps {
                sh "docker exec ${APP_CONTAINER} php artisan config:clear"
                sh "docker exec ${APP_CONTAINER} php artisan cache:clear"
                sh "docker exec ${APP_CONTAINER} php artisan migrate:fresh --path=database/custom_migrations --force"
                sh "docker exec ${APP_CONTAINER} php artisan db:seed"
            }
        }

        stage('Finish') {
            steps {
                echo 'Deployment selesai, aplikasi sudah berjalan!'
            }
        }
    }

    post {
        failure {
            echo 'Build gagal, cek log untuk detail kesalahan.'
        }
    }
}
