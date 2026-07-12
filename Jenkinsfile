pipeline {
    agent any

    environment {
        IMAGE_NAME     = 'tienda-uleam-payphone'
        CONTAINER_NAME = 'tienda-uleam-container'
        APP_PORT       = '8082'   // distinto a 8081 para no chocar con XAMPP
    }

    triggers {
        pollSCM('H/2 * * * *')    // revisa el repo cada 2 min
    }

    stages {
        stage('Checkout') {
            steps { checkout scm }
        }

        stage('Build') {
            steps {
                sh 'docker build -t ${IMAGE_NAME}:${BUILD_NUMBER} -t ${IMAGE_NAME}:latest .'
            }
        }

        stage('Test') {
            steps {
                sh '''
                    echo "Validando sintaxis PHP..."
                    docker run --rm ${IMAGE_NAME}:latest sh -c "find /var/www/html -name '*.php' -exec php -l {} \\;"
                '''
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                    docker stop ${CONTAINER_NAME} || true
                    docker rm ${CONTAINER_NAME} || true
                    docker run -d --name ${CONTAINER_NAME} -p ${APP_PORT}:80 ${IMAGE_NAME}:latest
                '''
            }
        }

        stage('Verify') {
            steps {
                sh '''
                    sleep 3
                    curl -f http://localhost:${APP_PORT}/index.php || exit 1
                    echo "Deploy verificado correctamente"
                '''
            }
        }
    }

    post {
        success { echo 'Build, test y deploy completados exitosamente.' }
        failure { echo 'El pipeline falló, revisa la etapa correspondiente en consola.' }
    }
}