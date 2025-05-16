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
                checkout scm
            }
        }

        stage('Build Images') {
            steps {
                bat "docker-compose -f ${COMPOSE_FILE} build"
            }
        }

        stage('Start Containers') {
            steps {
                bat "docker-compose -f ${COMPOSE_FILE} up -d"
            }
        }

        stage('Wait for MySQL Ready') {
            steps {
                script {
                    def ready = false
                    for (int i = 0; i < 12; i++) { // cek max 1 menit (12*5 detik)
                        def logs = bat(script: "docker logs ${MYSQL_CONTAINER}", returnStdout: true).trim()
                        if (logs.contains("ready for connections")) {
                            ready = true
                            break
                        }
                        bat "timeout /t 5 /nobreak"
                    }
                    if (!ready) {
                        error "MySQL tidak siap setelah timeout"
                    }
                }
            }
        }

        stage('Run Laravel Migration') {
            steps {
                bat "docker exec ${APP_CONTAINER} php artisan migrate --force"
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
