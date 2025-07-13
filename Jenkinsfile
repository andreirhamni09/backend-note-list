pipeline {
    agent any

    environment {
        APP_CONTAINER = 'backend-note-list'
        COMPOSE_CMD = 'docker compose' // gunakan 'docker-compose' jika Docker Compose v1
    }

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/andreirhamni09/backend-note-list.git', branch: 'master'
            }
        }

        // stage('Start MySQL (if needed)') {
        //     steps {
        //         script {
        //             def mysqlRunning = sh(
        //                 script: 'docker ps --filter "name=mysql-note-list" --filter "status=running" --format "{{.Names}}"',
        //                 returnStdout: true
        //             ).trim()

        //             if (mysqlRunning == '') {
        //                 echo "Starting MySQL container..."
        //                 sh "${COMPOSE_CMD} up -d mysql"
        //                 sh 'sleep 10' // delay to allow MySQL to initialize
        //             } else {
        //                 echo "MySQL already running."
        //             }
        //         }
        //     }
        // }

        // stage('Rebuild App & Webserver Containers') {
        //     steps {
        //         script {
        //             sh "${COMPOSE_CMD} stop app webserver || true"
        //             sh "${COMPOSE_CMD} rm -f app webserver || true"
        //             sh "${COMPOSE_CMD} build --no-cache app"
        //             sh "${COMPOSE_CMD} up -d app webserver"
        //         }
        //     }
        // }

        
        stage('Build & Run Docker') {
            steps {
                script {
                    bat 'docker-compose down --volumes'
                    bat 'docker-compose build --no-cache'
                    bat 'docker-compose up -d'
                }
            }
        }

        stage('Setup .env') {
            steps {
                script {
                    // Bersihkan dan siapkan file .env
                    sh 'rm -f app/.env || true'
                    sh 'cp -n app/.env.example app/.env || true'
                    sh 'chmod 777 app/.env'
                }
            }
        }

        stage('Run Laravel Migrations & Seeders') {
            steps {
                sh "${COMPOSE_CMD} exec -T ${APP_CONTAINER} php artisan config:clear"
                sh "${COMPOSE_CMD} exec -T ${APP_CONTAINER} php artisan cache:clear"
                sh "${COMPOSE_CMD} exec -T ${APP_CONTAINER} php artisan migrate:fresh --path=database/custom_migrations --force"
                sh "${COMPOSE_CMD} exec -T ${APP_CONTAINER} php artisan db:seed"
            }
        }

        stage('Finish') {
            steps {
                echo '✅ Deployment selesai, aplikasi sudah berjalan!'
            }
        }
    }

    post {
        failure {
            echo '❌ Build gagal, cek log error di atas.'
        }
    }
}
