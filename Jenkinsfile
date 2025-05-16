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

        stage('Wait for MySQL Ready') {
          steps {
              script {
                  def ready = false
                  for (int i = 0; i < 12; i++) {
                      def result = bat(
                          script: "docker exec backend-note-list php -r \"@mysqli_connect('mysql-note-list', 'root', 'P@ssw0rd') ? exit(0) : exit(1);\"",
                          returnStatus: true
                      )
                      if (result == 0) {
                          ready = true
                          break
                      }
                      echo "MySQL belum siap, tunggu 5 detik..."
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
