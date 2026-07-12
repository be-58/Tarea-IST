pipeline {

    agent any

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Verificar PHP') {
            steps {
                bat 'php -v'
            }
        }

        stage('Verificar Sintaxis') {
            steps {
                bat '''
                php -l index.php
                php -l response.php
                '''
            }
        }

        stage('Deploy') {
            steps {
                bat '''
                xcopy /E /Y * C:\\xampp\\htdocs\\proyecto-payphone\\
                '''
            }
        }

    }

    post {
        success {
            echo 'Proyecto PayPhone desplegado correctamente.'
        }

        failure {
            echo 'Ocurrió un error durante el despliegue.'
        }
    }

}