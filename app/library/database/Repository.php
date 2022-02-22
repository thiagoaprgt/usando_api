<?php
    
    // manipula coleções de objetos

    namespace library\database;

    use Exception;

    final class Repository {

        private $activeRecord; // classe manipulada pelo repositório
        
        function __construct($class){
            $this->activeRecord = $class;
        }        

        function load(Criteria $criteria, array $columns = null) {
            //instancia a instrução de SELECT 
            
            if($columns == null) {

                $sql = "SELECT * FROM " . constant($this->activeRecord . '::TABLENAME');

            }else {

                $sql = implode(", ", $columns);

                $sql = "SELECT $sql FROM " . constant($this->activeRecord . '::TABLENAME');

            }

            

            // obtém a cláusula WHERE do objeto criteria

            if($criteria) {

                $expression = $criteria->dump();

                if($expression) {

                    $sql .= ' WHERE ' . $expression;

                }

                // obtém as propriedades do critério

                $order = $criteria->getProperty('order');
                $limit = $criteria->getProperty('limit');
                $offset = $criteria->getProperty('offset');
                $group_by = $criteria->getProperty('groupby');

                // obtém a ordenação do SELECT

                if($order) {
                    $sql .= ' ORDER BY ' . $order;
                }

                if($limit) {
                    $sql .= ' LIMIT ' . $limit;
                }

                if($offset) {
                    $sql .= ' OFFSET ' . $offset;
                }

                if($group_by) {
                    $sql .= ' GROUP BY ' . $group_by;
                }

            }

            // obtém a transação ativa

            if($conn = Transaction::get()) {

                //Transaction::log($sql); // registra a mensagem de log

                // executa a consulta no banco de dados

                $result = $conn->Query($sql);
                $results = array();

                if($result) {

                    // percorre os resultados da consulta, retornando um objeto
                    // o nome da classe do objeto returnado é o nome que está em $this->activeRecord
                    // fazendo com que se possa usar os metódos do objeto retornado através 
                    // do objeto da classe Repository

                    while($row = $result->fetchObject($this->activeRecord)) {

                        // armazena no array $results;

                        $results[] = $row;

                    }

                }

                return $results;

            }else{

                throw new Exception('Não há transação ativa!!!');

            }
            
        }

        function delete(Criteria $criteria) {

            $expression = $criteria->dump();             

            $sql = "DELETE FROM " . constant($this->activeRecord . '::TABLENAME');
            if($expression) {
                $sql .= ' WHERE ' . $expression;
            }


            // obtém as propriedades do critério

            $order = $criteria->getProperty('order');
            $limit = $criteria->getProperty('limit');
            $offset = $criteria->getProperty('offset');
            $group_by = $criteria->getProperty('groupby');

            // obtém a ordenação do SELECT

            if($order) {
                $sql .= ' ORDER BY ' . $order;
            }

            if($limit) {
                $sql .= ' LIMIT ' . $limit;
            }

            if($offset) {
                $sql .= ' OFFSET ' . $offset;
            }

            if($group_by) {
                $sql .= ' GROUP BY ' . $group_by;
            }
          

            //obtém transação ativa

            if($conn = Transaction::get()) {

                //Transaction::log($sql); // registra a mensagem de log
                $result = $conn->exec($sql); // executa a instrução de DELETE
                return $result;

            }else {
                throw new Exception('Não há transação ativa!!!');
            }

        }

        function count(Criteria $criteria) {
            $expression = $criteria->dump();

            

            $sql = "SELECT count(*) FROM " . constant($this->activeRecord . '::TABLENAME');

            if($expression) {
                $sql .= ' WHERE ' . $expression;
            }

            // obtém a transação ativa

            if($conn = Transaction::get()) {

                //Transaction::log($sql); // registra a mensagem de log
                $result = $conn->query($sql); // executa a instrução de SELECT
                if($result) {
                    $row = $result->fetch();
                }

                return $row[0]; // retorna o resultado

            }else {
                throw new Exception('Não há transação ativa!!!!');
            }

        }


    }



?>