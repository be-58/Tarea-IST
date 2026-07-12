pipeline {

    agent any

    environment {
        IMAGE_NAME = "payphone-app"
        CONTAINER_NAME = "payphone-container"
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build') {
            steps {
                bat 'docker build -t %IMAGE_NAME% .'
            }
        }

        stage('Test') {
            steps {
                bat 'php -v'
            }
        }

        stage('Deploy') {
            steps {
                bat '''
                docker stop %CONTAINER_NAME%
                docker rm %CONTAINER_NAME%
                docker run -d --name %CONTAINER_NAME% -p 8081:80 %IMAGE_NAME%
                '''
            }
        }

    }

    post {

        success {
            echo 'Despliegue realizado correctamente.'
        }

        failure {
            echo 'Error durante el pipeline.'
        }

    }

}