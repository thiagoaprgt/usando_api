<?php

    class Api {

        private $config;
        private $conn;
        private $parameters;
        private $method;

        public function __construct() {

            $this->config = parse_ini_file("../config/config.ini");

            extract($this->config);

            

            $this->conn = new PDO("mysql:host=$database_host;dbname=$database_name", $database_user, $database_password);


            if(isset($_GET["method"])) {

                call_user_func( array( $this, $_GET["method"] ) );
                

            }else if(isset($_POST["method"])) {

                $this->method = $_POST["method"];

                
                
                call_user_func_array( array( $this, $this->method ), array( $_POST ) );

                

                

            }else {

                echo "Not Found";

            }

            $conn = null;

           
            

        }

        public static function authorization() {

           $headers = getallheaders();
           $authorization = $headers["Authorization"];

            return $authorization;

        }

        public function products() {
        
            if($_GET["method"] == "products") {
                
                

                

                $sql = "SELECT `id`, `name`, `available`, `sale_price`, `updated_at` FROM produtos";  

                $prepare = $this->conn->prepare($sql);
                $prepare->execute();

                $result = $prepare->fetchAll(PDO::FETCH_OBJ);

                $json = json_encode($result);    

                echo $json;   
                

                


            }

        }


        public function selectProducts($parameters) {
            
                        

            if($_POST["method"] == "selectProducts") {
                
                                
                extract($parameters);  
                
                if(is_string($searched_column_value)) {

                    $searched_column_value = "'$searched_column_value'";

                }
                

                $sql = "SELECT $column_names FROM produtos WHERE $searched_column $constraints $searched_column_value";  

               

                $prepare = $this->conn->prepare($sql);
                $prepare->execute();

                $result = $prepare->fetchAll(PDO::FETCH_OBJ);

                $json = json_encode($result);    

                echo $json; 


            }

        }


        public function delete($parameters) {

            if($_POST["method"] == "delete") {

                extract($parameters);

                $sql = "DELETE FROM produtos WHERE id = $id";

                $prepare = $this->conn->prepare($sql);
                $prepare->execute();

            }

        }


        public function save($parameters) {

            

            if($_POST["method"] == "save") {

                extract($parameters);

                if(isset($id) && !empty($id)){

                    $sql = "UPDATE produtos SET nome=$nome, estoque=$estoque, nota_fiscal=$nota_fiscal";

                    $prepare = $this->conn->prepare($sql);
                    $prepare->execute();

                }else {

                    $sql = "INSERT INTO produtos (nome, estoque, nota_fiscal) VALUES ($nome, $estoque, $nota_fiscal)";

                    $prepare = $this->conn->prepare($sql);
                    $prepare->execute();

                }
                
            }

        }

        public function allOrders() {

            $headers = getallheaders(); // retorna um array com todos cabeçalhos HTTP 

            if(isset($headers["invoiced"]) && $headers["invoiced"] = true ) {

                $sql = "SELECT id, invoiced, total, items, email FROM pedidos WHERE invoiced > 0";

            }else {

                $sql = "SELECT id, invoiced, total, items, email FROM pedidos";

            }

           

            $prepare = $this->conn->prepare($sql);

            $prepare->execute();

            $result = $prepare->fetchAll(PDO::FETCH_OBJ);

            $json = json_encode($result);    

            echo $json; 

        }

        public function listAllOrdersWithInvoice() {
           
           

            echo "<pre>";
            print_r(getallheaders());
            echo "</pre>";

            if(isset($_GET["teste"]) && $_GET["teste"] == true) {
                $headers = get_headers($url);

            }

        }



    }




?>