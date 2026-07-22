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
                    echo "=== Test 1: Sintaxis PHP ==="
                    docker run --rm ${IMAGE_NAME}:latest sh -c "find /var/www/html -name '*.php' -exec php -l {} \\;"
                '''

                sh '''
                    echo "=== Test 2: Archivos criticos presentes en la imagen ==="
                    docker run --rm ${IMAGE_NAME}:latest sh -c "test -f /var/www/html/index.php && test -f /var/www/html/response.php && echo 'index.php y response.php existen'"
                '''

                sh '''
                    echo "=== Test 3: Extension curl habilitada (requerida por PayPhone API) ==="
                    docker run --rm ${IMAGE_NAME}:latest php -m | grep -qi curl && echo "curl extension OK" || (echo "FALTA extension curl" && exit 1)
                '''

                sh '''
                    echo "=== Test 4: index.php responde con contenido esperado (smoke test) ==="
                    docker run -d --rm --name test-smoke-${BUILD_NUMBER} -p 8090:80 ${IMAGE_NAME}:latest
                    sleep 3
                    docker exec test-smoke-${BUILD_NUMBER} curl -s http://localhost/index.php | grep -q "Tienda Uleam Prueba" && echo "Contenido esperado encontrado" || (echo "Contenido esperado NO encontrado" && docker stop test-smoke-${BUILD_NUMBER} && exit 1)
                    docker stop test-smoke-${BUILD_NUMBER}
                '''

                sh '''
                    echo "=== Test 5: response.php no genera error fatal sin parametros ==="
                    docker run -d --rm --name test-response-${BUILD_NUMBER} -p 8091:80 ${IMAGE_NAME}:latest
                    sleep 3
                    docker exec test-response-${BUILD_NUMBER} curl -s -o /dev/null -w "%{http_code}" http://localhost/response.php | grep -q "200" && echo "response.php responde OK sin parametros" || (echo "response.php fallo" && docker stop test-response-${BUILD_NUMBER} && exit 1)
                    docker stop test-response-${BUILD_NUMBER}
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
                    docker exec ${CONTAINER_NAME} curl -f http://localhost/index.php || exit 1
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