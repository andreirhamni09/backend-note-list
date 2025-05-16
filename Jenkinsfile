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
                    for (int i = 0; i < 100; i++) {
                        def logs = bat(script: "docker logs ${MYSQL_CONTAINER}", returnStdout: true).trim()
                        if (logs.contains("ready for connections")) {
                            ready = true
                            break
                        }
                        bat 'ping -n 6 127.0.0.1 >nul'
                    }
                    if (!ready) {
                        error "MySQL tidak siap setelah timeout"
                    }
                }
            }
        }

        stage('Run Laravel Migration') {
            steps {
                bat "docker exec ${APP_CONTAINER} php artisan migrate --path=database/custom_migrations --force"
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
