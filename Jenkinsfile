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

    stage('Prepare .env') {
      steps {
        bat 'copy .env.example .env'
      }
    }

    stage('Build & Start Containers') {
      steps {
        bat 'docker-compose down -v || true'
        bat 'docker-compose build --no-cache'
        bat 'docker-compose up -d'
      }
    }

    stage('Install Dependencies') {
      steps {
        bat "docker exec ${APP_SERVICE} composer install --no-interaction --prefer-dist"
      }
    }
    
    stage('Fix Permissions (for Windows Docker volumes)') {
      steps {
        // Hanya akan bekerja di container (tidak di host Windows)
        bat "docker exec ${APP_SERVICE} chmod 664 /var/www/.env"
        bat "docker exec ${APP_SERVICE} chown www-data:www-data /var/www/.env"
      }
    }

    stage('Laravel Setup') {
      steps {
        bat "docker exec ${APP_SERVICE} php artisan config:clear"
        bat "docker exec ${APP_SERVICE} php artisan key:generate"
        bat "docker exec ${APP_SERVICE} php artisan migrate --force"
      }
    }

    stage('Test') {
      steps {
        bat "docker exec ${APP_SERVICE} php artisan test || true"
      }
    }
  }

  post {
    always {
      echo 'Build pipeline complete.'
    }
  }
}
