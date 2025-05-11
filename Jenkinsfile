pipeline {
  agent any

  environment {
    COMPOSE_FILE = 'docker-compose.yml'
    APP_SERVICE = 'backend-note-list'
  }

  stages {
    stage('Checkout') {
      steps {
        git 'https://github.com/andreirhamni09/backend-note-list.git'
      }
    }
    
    stage('Build and Start Docker') {
        steps {
            bat 'docker-compose down'
            bat 'docker-compose up -d --build'
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
    
    stage('Fix File Permissions') {
        steps {
            bat "docker exec ${APP_SERVICE} chmod 664 /var/www/.env"
        }
    }

    stage('Laravel Setup') {
      steps {
        bat "docker exec ${APP_SERVICE} php artisan config:clear"
        bat "docker exec ${APP_SERVICE} php artisan cache:clear"
        bat "docker exec ${APP_SERVICE} php artisan config:cache"
        bat "docker exec ${APP_SERVICE} php artisan key:generate"
      }
    }
  }

  post {
    always {
      echo 'Build pipeline complete.'
    }
  }
}
