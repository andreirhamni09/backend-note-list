pipeline {
    agent any

    stages {
        stage('Clone Repository') {
            steps {
                git url: 'https://github.com/andreirhamni09/backend-note-list.git', branch: 'master'
            }
        }

        stage('Cleanup Docker (Optional)') {
            steps {
                // Stop and remove all matching containers (if exists)
                bat '''
                docker stop backend-note-list || exit 0
                docker stop mysql-note-list || exit 0
                docker stop nginx-note-list || exit 0
                docker rm backend-note-list || exit 0
                docker rm mysql-note-list || exit 0
                docker rm nginx-note-list || exit 0
                docker volume rm backend-note-list_dbdata || exit 0
                '''
            }
        }

        stage('Build and Start Docker') {
            steps {
                bat 'docker-compose down -v --remove-orphans'
                bat 'docker-compose build --no-cache'
                bat 'docker-compose up -d'
            }
        }

        stage('Laravel Setup') {
            steps {
                bat 'docker exec backend-note-list composer install'
                bat 'ping -n 11 127.0.0.1 > nul' // ini delay pengganti timeout
                bat 'docker exec backend-note-list php artisan key:generate'
            }
        }
    }
}
