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
                sh 'docker build -t $IMAGE_NAME .'
            }
        }

        stage('Test') {
            steps {
                sh '''
                echo "==========="
                echo "Pruebas"
                echo "==========="
                docker images
                '''
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                docker stop $CONTAINER_NAME || true
                docker rm $CONTAINER_NAME || true

                docker run -d \
                --name $CONTAINER_NAME \
                -p 8081:80 \
                $IMAGE_NAME
                '''
            }
        }
    }

    post {

        success {
            echo 'Proyecto desplegado correctamente'
        }

        failure {
            echo 'Falló el despliegue'
        }
    }

}