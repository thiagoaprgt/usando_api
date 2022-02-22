<?php

    require_once "library/database/Recordinterface.php";
    

    


    /**
     * Permite definir um active Record
    */


    abstract class Record implements RecordInterface {

        protected $data; // array contendo os dados do objeto

        // Instancia um active record se passado o $id, já carrega o objeto

        

        public function __construct($id = null) {

            if($id) { 

                // se o id for informado carrega o objeto correpondente

                $object = $this->load($id);
                if($object) {

                    $this->fromArray($object->toArray());

                }
                
                
            }

        }

        // Limpa o ID para que seja um novo ID para o clone

        public function __clone() {

            unset($this->data['id']);

        }


        // Executado sempre que uma propriedade for atribuída

        public function __set($prop, $value) {

            // verifica se existe método se_<propriedade>

            if(method_exists($this, 'set_' . $prop)) {

                // executa o método set_<propriedade>

                call_user_func(array($this, 'set' . $prop), $value);

            }else {

                if($value === NULL) {

                    unset($this->data[$prop]);

                }else {

                    // atribui o valor da propriedade

                    $this->data[$prop] = $value;

                }

            }

        }

        // Executado sempre que uma propriedade for requerida

        public function __get($prop) {

            // verifica se existe um método get_<propriedade>

            if(method_exists($this, 'get' . $prop)) {

                // executa o método get_<propriedade>

                return call_user_func(array($this, 'get' . $prop));

            }else {

                // retorna o valor da propriedade

                if(isset($this->data[$prop])) {

                    return $this->data[$prop];

                }

            }

        }

        
        // Retorna se a propriedade está definida

        public function __isset($prop) {

            return isset($this->data[$prop]);

        }


        // Retorna o nome da entidade (tabela)

        public function getEntity() {

            // obtém o nome da classe

            $class = get_class($this);

            // retorna o constante de classe TABLENAME

            return constant("{$class}::TABLENAME");

        }


        //  Preenche os dados do objeto com um array

        public function fromArray($data) {

            $this->data = $data;
            
        }

        // Retorna os dados do objeto como array

        public function toArray() {

            return $this->data;

        }

        // Armazena o objeto na base de dados

        public function store() {

            $prepared = $this->prepare($this->data);

            // verifica se tem ID ou se existe na base de dados

            if(empty($this->data['id']) or (!$this->load($this->id))) {

                // incrementa o ID
                

                if(empty($this->data['id'])) {
                    /*
                    $this->id = $this->getLast() + 1;
                    $prepared['id'] = $this->id;
                    */

                    // estou usando auto_increment
                    
                }

                

                // cria uma instrução insert

                $sql = "INSERT INTO {$this->getEntity()}" . 
                    '(' . implode(', ', array_keys($prepared)) . ')' . 
                    ' values ' . 
                    '(' . implode(', ', array_values($prepared)) . ')'
                    
                ;

            }else {

                // monta a string de update

                $sql = " UPDATE {$this->getEntity()}";

                // monta os pares: coluna=valor, ... 

                if($prepared) {

                    foreach($prepared as $column => $value) {

                        if($column !== 'id') {

                            $set[] = "{$column} = {$value}";

                        }

                    }

                }

                $sql .= ' SET ' . implode(', ', $set);
                $sql .= ' WHERE id=' . (int) $this->data['id'];

            }

            // obtém a transação ativa

            if($conn = Transaction::get()) {

                // faz o log e executa o SQL

                //Transaction::log($sql);
                $result = $conn->exec($sql);

                // retorna o resultado

                return $result;

            }else {

                // se não tiver a transação, retorna uma exceção

                throw new Exception('Não há transação ativa !!');

            }


        }


        // Recupera (retorna) um objeto da base de dados pelo seu ID
        // @param $id = ID do objeto

        public function load($id) {

            // instancia a instrução de SELECT

            $sql = "SELECT * FROM {$this->getEntity()}";
            $sql .= ' WHERE id=' . (int) $id;

            // obtém a transação ativa

            if($conn = Transaction::get()) {

                // cria mensagem de log e executa a consulta

                Transaction::log($sql);
                $result = $conn->query($sql);

                // se retornou algum dado

                if($result) {

                    // retorna os dados em forma de objeto

                    $object = $result->fetchObject(get_class($this));

                }

                return $object;

            }else {

                // se não tiver transação, retorna uma exceção

                throw new Exception('Não há transação ativa !!');

            }

        }

        // Exclui um objeto da base de dados através de seu ID.

        public function delete($id = NULL) {

            // o ID é o parâmetro ou a propriedade ID

            $id = $id ? $id : $this->id;

            // monsta a string de UPDATE

            $sql = "DELETE FROM {$this->getEntity()}";
            $sql .= ' WHERE id=' . (int) $this->data['id'];

            // obtém a transação ativa

            if ($conn = Transaction::get()) {

                // faz o log e executa o SQL

                Transaction::log($sql);
                $result = $conn->exec($sql);

                return $result;

            }else {

                // se não tiver transação, retorna uma exceção

                throw new Exception('Não há transação ativa !!');

            }   

        }


        // Retorna o último ID

        private function getLast() {

            // inicia a transação

            if($conn = Transaction::get()) {

                // instancia a instrução de SELECT

                $sql = "SELECT id FROM {$this->getEntity()} WHERE id=null ";

                $result = $conn->query($sql);
                $null_ID = $result->fetch();
                

                

                // instancia a instrução de SELECT

                $sql = "SELECT max (id) FROM {$this->getEntity()}";

                // Cria o log e executa a instrução SQL

                //Transaction::log($sql);

                $result = $conn->query($sql);
                $row = $result->fetch();

                return $row[0];

               
            

                

                

            }else {

                // se não tiver a transação, retorna uma exceção

                throw new Exception('Não há transação ativa');

            }

        }

        // Retorna todos os objetos

        public function all() {

            $classname = get_called_class();
            $rep = new Repository($classname);
            return $rep->load(new Criteria);

        }

        // Busca um objeto pelo id

        public function find($id) {

            $classname = get_called_class();
            $ar = new $classname;
            return $ar->load($id);

        }

        public function prepare($data) {


            $prepared = array();

            foreach($data as $key => $value) {

                if(is_scalar($value)) {

                    $prepared[$key] = $this->escape($value);

                }

            }

            return $prepared;

        }

        public function escape($value) {

            // verifica se é um dado escalar (string, inteiro, ...)

            if(is_scalar($value)) {

                if(is_string($value) and (!empty($value))) {

                    // adiciona \ em aspas
                    $value = addslashes($value);
                    // caso seja uma string
                    return "'$value'";

                }else if (is_bool($value)) {

                    // caso seja um boolean

                    return $value ? 'TRUE' : 'FALSE';

                }else if ($value !== '') {

                    // caso seja outro tipo de dado

                    return $value;

                }else {

                    // caso seja NULL

                    return "NULL";

                }

            }

        }

    }



?>