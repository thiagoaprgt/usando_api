<?php
    

    class Stokki {

        protected $url;
        protected $url_teste;
        protected $headers;
        protected $info;
        protected $http;
        protected $activeRecord;
        
        protected static $teste;
        protected static $debugHeader;

        public function __construct() {

            require_once "library/Http.php";            

            $config = parse_ini_file("config/config.ini");

            extract($config);
            
            $this->url = $api_url;
            $this->url_teste = $api_url_teste;            

            $this->headers = [

                "Authorization: Bearer $token",
                "access_token: $token",
                "email: $email",
                "password: $password"        
                
            ];

            $teste = Stokki::getTest();


            $this->http = new Http;

          

            if(!empty($_GET["method"]) && count($_GET) > 2 ) {
                

                if( isset($_GET["class"]) && !empty($_GET["class"]) ) {

                   
                    array_shift($_GET);


                }
                                
                $method = $_GET["method"];

                array_shift($_GET);  

            
                

                $action = call_user_func_array( array($this, $method), $_GET );
                
                if(isset($action["table"])) {
                    print_r($action["table"]);
                }
                


            }else if( !empty($_GET["method"]) ) {
                

                $action = call_user_func( array($this, $_GET["method"]) );

                if(isset( $action["table"] ) ) {

                    print_r($action["table"]);

                }else {
                    echo $action;
                }

            }else {

                echo "Faça uma busca na API";

            }


            


            
            
           

        }

             
        public static function getTest() {
            return self::$teste;
        }     


        public static function setTest(bool $teste = false) {
            self::$teste = $teste;
        }


        public static function setDebugHeader(bool $debugHeader = false) {
            self::$debugHeader = $debugHeader;
        }

        public static function getDebugHeader() {
            return self::$debugHeader;
        }


        public function debugHeader(object $curl) {
            

            echo "<pre>";

            echo "<br>";
            echo "<p> Endpoind usado: " . $this->getUrl() . "</p>";

            echo "<p>Modo desenvolvedor debug header ativado </p>";

            echo "<p>Para desativá-lo mude o parâmetro true da função </p>";

            echo "<p>Stokki::setDebugHeader(true)  para false </p>";

            echo "<p>no arquivo localizado em app/index.php </p>";

            echo "<p> Array do cabeçalho HTTP usado nas requições (curl) enviadas para API : </p>";

            print_r( curl_getinfo($curl)["request_header"] );

            echo "</pre>";

        }


        public function table(array $object) {

            // tabela
    
            $table = file_get_contents("templates/table/table.html");
            $th = file_get_contents("templates/table/th.html");        
            $tr =  file_get_contents("templates/table/tr.html");
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
        
        public function getUrl() {

            $teste = self::getTest();

            if($teste == false) {

                return $this->url;

            }else {

                return $this->url_teste;

            }

        }


      


    }



?>