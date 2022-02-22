<?php


    class Stokki_pedidos extends Stokki {

        private static $content;

        public function __construct() {
            parent::__construct();

            $teste = Stokki::getTest();

            if($teste == true) {

                $content = "Página dos pedidos: Ambiente de teste";
        
            }else {
        
                $content = "Página dos pedidos: Ambiente final que vai para a produção";
        
            }

            self::$content = $content;

        }

        public static function getContent() {
            return self::$content;
        }

        public function home() {

        }

        public function listAllOrderedWithInvoice(string $start = "", string $finish = "", int $page = 1, int $per_page = 100) {
            // invoice = nota fiscal 
            // o máximo número do parâmetro per_page é 100 segundo a documentação da api da empresa Stokki
            
            $endpoint = $this->url;  
            $endpoint_teste = $this->url_teste;

            $this->headers[] = "start: $start";
            $this->headers[] = "finish: $finish";
            $this->headers[] = "page: $page";
            $this->headers[] = "per_page: $per_page";

            $data = [
                "method" => "listAllOrderedWithInvoice"
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

    }


?>