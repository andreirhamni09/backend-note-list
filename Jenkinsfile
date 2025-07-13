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
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/master']], // ganti 'main' jika default branch-mu 'master'
                    userRemoteConfigs: [[
                        url: 'https://github.com/andreirhamni09/backend-note-list.git',
                        credentialsId: 'github-token-jenkins'
                    ]]
                ])
            }            
        }
         stage('Ensure MySQL is Running') {
            steps {
                script {
                    def mysqlRunning = bat(
                        script: 'docker ps --filter "name=mysql-note-list" --filter "status=running" --format "{{.Names}}"',
                        returnStdout: true
                    ).trim()

                    if (mysqlRunning == '') {
                        echo "MySQL container is not running. Building and starting MySQL..."
                        bat 'docker-compose build mysql'
                        bat 'docker-compose up -d mysql'
                        bat 'timeout /t 10'
                    } else {
                        echo "MySQL container is already running."
                    }
                }
            }
        }

        stage('Rebuild App and Webserver Only') {
            steps {
                bat 'docker-compose rm -fs app webserver'
                bat 'docker-compose build --no-cache app webserver'
                bat 'docker-compose up -d app webserver'
            }
        }

        stage('Remove .env') {
            steps {
                bat 'del app\\.env'
            }
        }

        stage('Prepare .env') {
            steps {
                bat 'if not exist app\\.env copy app\\.env.example app\\.env'
                bat 'icacls app\\.env /grant Everyone:F'
            }
        }

        stage('Run Laravel Migration') {
            steps {
                bat "docker exec ${APP_CONTAINER} php artisan config:clear"
                bat "docker exec ${APP_CONTAINER} php artisan cache:clear"
                bat "docker exec ${APP_CONTAINER} php artisan migrate:fresh --path=database/custom_migrations --force"
                bat "docker exec ${APP_CONTAINER} php artisan db:seed"
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
