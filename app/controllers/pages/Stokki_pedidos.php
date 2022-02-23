<?php


    class Stokki_pedidos extends Stokki {

        private static $content;

        public function __construct() {
            parent::__construct();

            $teste = Stokki::getTest();

            $content =  file_get_contents("templates/section/listarPedidos.html");

            self::$content = $content;

        }

        public static function getContent() {
            return self::$content;
        }

        public function allOrders(string $start = "", string $finish = "", bool $invoiced = false, int $page = 1, int $per_page = 100) {

            // invoice = nota fiscal 
            // o máximo número do parâmetro per_page é 100 segundo a documentação da api da empresa Stokki
            

            $endpoint = $this->url;  
            $endpoint_teste = $this->url_teste;

            $this->headers[] = "invoiced: $invoiced";
            $this->headers[] = "start: $start";
            $this->headers[] = "finish: $finish";
            $this->headers[] = "page: $page";
            $this->headers[] = "per_page: $per_page";
            

            $data = [
                "method" => "allOrders" 
            ];

            $api = $this->http;
            

            if(self::$teste == false) {

                $result = $api->get($endpoint, $data, $this->headers);

            }else if(self::$teste == true) {

                
                $result = $api->get($endpoint_teste, $data, $this->headers);

            }


            if(self::$debugHeader == true) {

                $this->debugHeader( $result["curlHandle"] );
                
            }

            $object = json_decode($result["output"]);

            if( is_array($object) || is_object($object) ) {

                // isso foi feito para reaproveitar a funnção

                $result["table"] = $this->table($object);           
           
                return $result;  
                

            }else {

                return $result["output"];

            }


            
        }


        public function saveAllOrders() {

            $data = $this->allOrders();
            
            $orders_data = json_decode( $data["output"] );

            Transaction::open("database");

            $table = new Pedidos;                    

            foreach($orders_data as $obj) {
                
                $objVars = get_object_vars($obj);

                $id = $objVars["id"];

                $table = new Pedidos($id);


              
                if(isset($table->id)) {

                    // Já existe no banco de dados

                    $update = $table->load($id);
                    $update->fromArray($objVars);
                    $update->store();
                    

                }else {

                    //Não existe no banco de dados
                    $table->fromArray($objVars);
                    $table->store();
                }

               
                

            }


            Transaction::close();

        }


        public function table(array $object) {

            // tabela
    
            $table = file_get_contents("templates/table/stokki_pedidos/orders_table.html");
            $th = file_get_contents("templates/table/th.html");        
            $tr =  file_get_contents("templates/table/stokki_pedidos/orders_tr.html");
            $td = file_get_contents("templates/table/td.html");
    
            $rowData = "";
            $row = "";
    
            //  get_object_vars retorna um array com os atributos do objeto 
    
            $table_columns = get_object_vars($object[0]);
    
            // array_keys retorna um array com os chaves do arrays
    
            $table_columns = array_keys($table_columns);
            
    
            $thData = "";
    
            foreach($table_columns as $column) {
    
                $thData .= str_replace("{{thData}}", $column, $th);
    
            }
    
            $table = str_replace("{{th}}", $thData, $table);
    
            foreach($object as $key => $values) {
               
                foreach($values as $k => $value) {
                    
                    $rowData .= str_replace("{{tdData}}", $value, $td);
                    
                    ( $k == "id") ? $id = $k : "";
    
                }
    
                $row .= str_replace("{{trData}}", $rowData, $tr);   
    
                            
                if(isset($id) && $id == "id") {               
    
                    $row = str_replace("{{id}}", $values->id, $row);    
    
                }                  
    
                
    
                $rowData = "";
    
            }
    
    
            $table = str_replace("{{tr}}", $row, $table);
    
            return $table;
    
        }

        

    }


?>