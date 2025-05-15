pipeline {
  agent any

  environment {
    COMPOSE_FILE = 'docker-compose.yml'
    APP_SERVICE = 'backend-note-list'
    DB_HOST = 'mysql-note-list'
    DB_PORT = '3306'
    WAIT_SCRIPT = 'docker/wait-for-it.sh'
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
        bat 'if exist del app\\.env'
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

    stage('Wait for MySQL') {
      steps {
        bat "docker cp ${WAIT_SCRIPT} ${APP_SERVICE}:/wait-for-it.sh"
        bat "docker exec ${APP_SERVICE} chmod +x /wait-for-it.sh"
        bat "docker exec ${APP_SERVICE} /wait-for-it.sh ${DB_HOST}:${DB_PORT} --timeout=60 --strict -- echo MySQL is up"
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
