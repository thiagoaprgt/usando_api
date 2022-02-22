<?php

    
  
    // Cria conexões com o banco de dados

    final class Connection {

        // não pode haver instâncias de Connection

        private function __construct() {}

        // Recebe o nome de conector de banco de dados e instancia o objeto PDO

        public static function open($name) {

            // verifica se existe arquivo de configuração para este banco de dados

            if(file_exists("config/{$name}.ini")) {

                // lê o arquivo INI e retorna um array

                $db = parse_ini_file("config/{$name}.ini");


            }else {

                // se não existir, lança um erro

                throw new Exception("Arquivo '$name' não encontrado");

            }


            // lê as informações contidas no arquivo

            $user = isset($db['database_user']) ? $db['database_user'] : NULL;
            $pass = isset($db['database_password']) ? $db['database_password'] : NULL;
            $name = isset($db['database_name']) ? $db['database_name'] : NULL;
            $host = isset($db['database_host']) ? $db['database_host'] : NULL;
            $type = isset($db['database_type']) ? $db['database_type'] : NULL;
            $port = isset($db['database_port']) ? $db['database_port'] : NULL;

            // descobre qual o tipo (driver) de banco de dados a ser utilizado

            switch($type) {


                case 'pgsql':

                    $port = $port ? $port : '5432';
                    $conn = new PDO("pgsql:dbname={$name}; user={$user}; password={$pass}; host={$host}; port={$port}");

                break;

                case 'mysql':

                    $port = $port ? $port : '3306';
                    $conn = new PDO("mysql:host={$host}; port={$port}; dbname={$name}", $user, $pass);

                break;


                case 'sqlite':

                    $conn = new PDO("sqlite:{$name}");
                    $conn->query('PRAGMA foreign_keys = ON');

                break;


                case 'ibase':

                    $conn = new PDO("firebird:dbname={$name}", $user, $pass);

                break;


                case 'oci8':

                    $conn = new PDO("dblib:host={$host},1433,dbname={$name}, $user, $pass");

                break;

            }

            // define para que o PDO lance as exceções na ocorrência de erros

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;


        }

    }




?>