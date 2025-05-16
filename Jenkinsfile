pipeline {
    agent any

    environment {
        IMAGE_NAME = 'backend-note-list'
        DOCKERFILE_PATH = 'docker/php/Dockerfile'
        COMPOSE_FILE = 'docker-compose.yml'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    docker.build("${IMAGE_NAME}", "-f ${DOCKERFILE_PATH} .")
                }
            }
        }

        stage('Run Containers') {
            steps {
                // Jalankan docker-compose up di mode detached
                bat "docker-compose -f ${COMPOSE_FILE} up -d --build"
            }
        }

        stage('Wait for MySQL Ready') {
            steps {
                // Tunggu MySQL siap dengan cek port 3306
                // Bisa diganti sesuai kebutuhan
                bat '''
                echo "Menunggu MySQL siap..."
                until nc -z mysql-note-list 3306; do
                    echo "MySQL belum siap, tunggu 5 detik..."
                    sleep 5
                done
                echo "MySQL siap."
                '''
            }
        }

        stage('Run Migrations') {
            steps {
                // Jalankan migration Laravel via docker exec di container app
                bat "docker exec backend-note-list php artisan migrate --path=database/custom_migrations --force"
            }
        }

        stage('Post Deployment') {
            steps {
                echo "Deployment selesai!"
                // Tambahkan langkah lain seperti testing, notify, dll
            }
        }
    }

    post {
        always {
            echo 'Pipeline selesai'
        }
        failure {
            echo 'Pipeline gagal, cek log'
        }
    }
}
