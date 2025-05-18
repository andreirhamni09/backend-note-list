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

      stage('Build and Start Docker') {
        steps {
            bat 'docker-compose down --remove-orphans'
            bat 'docker-compose build --no-cache'
            bat 'docker-compose up -d'
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
