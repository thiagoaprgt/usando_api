<?php

    

    class Stokki_produtos extends Stokki {

        private static $content;

        public function __construct() {

            parent::__construct();

            $teste = Stokki::getTest();

            if($teste == true) {

                $content = file_get_contents("templates/section/listarProdutos_teste.html");
        
            }else {
        
                $content = file_get_contents("templates/section/listarProdutos.html");
        
            }

            self::$content = $content;

        }

        public static function getContent() {
            return self::$content;
        }


        public function listAllProducts() {

            // $endpoint = "https://demo.vnda.com.br/api/v2/" . "products";

            $endpoint = $this->url . "products";
            $endpoint_teste = $this->url_teste;
                        
            $http = $this->http;

            if(self::$teste == false) {  
                
                
                $result = $http->get($endpoint, $data = [], $this->headers );
                

            }else {     

                $data = [
                    "method" => "products"
                ];

                $result = $http->get($endpoint_teste, $data, $this->headers );    
                
            }

            if(self::$debugHeader == true) {

                $this->debugHeader( $result["curlHandle"] );
                
            }
            
            
            $object = json_decode($result["output"]);

            //print_r($object);


            if( is_array($object) || is_object($object) ) {

                $result["table"] = $this->table($object);           
           
                return $result;  

                

            }else {

                return $result["output"];

            }
        
           
            

            
        }


        public function selectProducts($column_names, $searched_column, $constraints, $searched_column_value, $debugHeader = false) {

            $endpoint = $this->url;  
            $endpoint_teste = $this->url_teste;  

        

            $data = [ 
            
            "method" => "selectProducts",
            "column_names" => $column_names,
            "searched_column" => $searched_column,
            "constraints" => $constraints,
            "searched_column_value" => $searched_column_value 
            ];

            $api = $this->http;

            if(self::$teste == false) {

                $result = $api->post($endpoint, $data, $this->headers);

            }else if(self::$teste == true) {

                
                $result = $api->post($endpoint_teste, $data, $this->headers);

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
        

        public function saveAllProducts() {

            $data = $this->listAllProducts();
            
            $products_data = json_decode( $data["output"] );

            Transaction::open("database");

            $table = new Produtos;                    

            foreach($products_data as $obj) {
                
                $objVars = get_object_vars($obj);

                $id = $objVars["id"];

                $table = new Produtos($id);


              
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

    }







?>