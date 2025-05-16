pipeline {
  agent any

  environment {
    COMPOSE_FILE = 'docker-compose.yml'
    APP_SERVICE = 'backend-note-list'
    DB_HOST = 'mysql-note-list'
    DB_PORT = '3306'
    WAIT_SCRIPT = 'docker/wait-for-mysql.sh'
  }

  stages {
    stage('Checkout') {
      steps {
        git 'https://github.com/andreirhamni09/backend-note-list.git'
      }
    }
    
    stage('Setup Network') {
      steps {
        bat "docker network create laravel"
        bat "docker network connect laravel mysql-note-list"
      }
    }

    stage('Build and Start Docker') {
      steps {
        bat 'docker-compose down -v'
        bat 'docker-compose build'
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
    
    stage('Fix File Permissions') {
      steps {
        bat "docker exec ${APP_SERVICE} chmod 664 /var/www/.env"
      }
    }

    stage('Fix Line Endings (Optional)') {
      steps {
        bat "powershell -Command \"(Get-Content docker/wait-for-mysql.sh) -replace '\\r','' | Set-Content docker/wait-for-mysql.sh\""
      }
    }

    stage('Laravel Setup') {
      steps {
        bat "docker exec ${APP_SERVICE} php artisan config:clear"
        bat "docker exec ${APP_SERVICE} php artisan cache:clear"
        bat "docker exec ${APP_SERVICE} php artisan config:cache"
        bat "docker exec ${APP_SERVICE} php artisan key:generate"
        bat "docker exec ${APP_SERVICE} php artisan migrate --path=database/custom_migrations --force"
      }
    }
  }

  post {
    always {
      echo 'Build pipeline complete.'
    }
  }
}
