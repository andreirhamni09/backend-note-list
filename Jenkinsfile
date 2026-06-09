pipeline {
    agent any

    environment {
        COMPOSE_FILE = 'docker-compose.yml'
        APP_CONTAINER = 'backend-note-list'

    }

    stages {
        stage('Checkout') {
            steps {
                git url: 'https://github.com/andreirhamni09/backend-note-list.git', branch: 'master'
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
        
        stage('Install Dependencies') {
            steps {
                bat "docker exec ${APP_CONTAINER} composer install --no-interaction --prefer-dist --optimize-autoloader"
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
