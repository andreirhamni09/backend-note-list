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
        bat 'cp .env.example .env'
      }
    }

    stage('Docker Compose Build') {
      steps {
        bat 'docker-compose down -v || true'
        bat 'docker-compose build --no-cache'
        bat 'docker-compose up -d'
      }
    }

    stage('Install Composer Dependencies') {
      steps {
        bat "docker exec ${APP_SERVICE} composer install --no-interaction --prefer-dist"
      }
    }

    stage('Set Laravel Permissions') {
      steps {
        bat "docker exec ${APP_SERVICE} chown -R www-data:www-data storage bootstrap/cache"
        bat "docker exec ${APP_SERVICE} chmod -R 775 storage bootstrap/cache"
      }
    }

    stage('Laravel Setup') {
      steps {
        bat "docker exec ${APP_SERVICE} php artisan config:clear"
        bat "docker exec ${APP_SERVICE} php artisan key:generate"
        bat "docker exec ${APP_SERVICE} php artisan migrate --force"
      }
    }

    stage('Run Laravel Tests') {
      steps {
        bat "docker exec ${APP_SERVICE} php artisan test || true"
      }
    }
  }

  post {
    success {
      echo '✅ Build and deployment successful!'
    }
    failure {
      echo '❌ Build failed.'
    }
    always {
      echo 'ℹ️ Pipeline completed.'
    }
  }
}
