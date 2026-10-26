
pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build and Deploy') {
            steps {
                withCredentials([
                    string(
                        credentialsId: 'laravel-app-key',
                        variable: 'APP_KEY'
                    )
                ]) {
                    sh '''
                        set -eu
                        docker compose -p laravel-app config --quiet
                        docker compose -p laravel-app up -d --build
                        docker compose -p laravel-app exec -T app php artisan migrate --force
                    '''
                }
            }
        }

        stage('Smoke Test') {
            steps {
                sh '''
                    curl --fail --silent --show-error \
                        http://localhost:8081/ > /dev/null
                '''
            }
        }
    }

    post {
        success {
            echo 'Laravel deployment and smoke test succeeded.'
        }
        failure {
            echo 'Pipeline failed. Check the stage console output.'
        }
    }
}
