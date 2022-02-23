<?php

    class Upload  {

        private static $content;

        public function __construct() {            
           

            $file = $this->upload($_FILES);

            $this->saveInformationDatabase($file, $_GET["id"]);


        }

        public static function getContent() {
            return self::$content;
        }

        

        public function upload($file) {

            if(isset($_FILES["arquivo"])) {
                
               try{

                $file = $_FILES["arquivo"];


                /*
                echo "<pre>";
                print_r($file);
                echo "</pre>";
                */


                if($file["size"] > 3145728) {
                    throw new Exception("O arquivo não pode ultrapassar 3 MB");
                }
                
                if($file["error"]) {
                    throw new Exception("Falha ao enviar o arquivo");
                }

                $directory = "upload/xml/";
                $fileName = $file["name"];
                $newFileName = uniqid();

                $fileExtension = strtolower( pathinfo($fileName, PATHINFO_EXTENSION) );

                if($fileExtension != "xml") {
                    throw new Exception("Esse arquivo não é um xml");
                }

                $newDirectory = $directory . $newFileName . "." . $fileExtension;

                $movedFile = move_uploaded_file($file["tmp_name"], $newDirectory);

                if($movedFile) {
                    echo "Arquivo movido com sucesso.";
                }else {
                    echo "Falha ao enviar o arquivo";
                }

               }catch(Exception $e) {
                   echo $e->getMessage();
               }

            }

           

            return $fileInfo = [

                "path" => $newDirectory,
                "file_name" => $fileName,
                "file_extension" => $fileExtension,
                
            ];

            
          

            

        }


        public function saveInformationDatabase(array $file, int $id_pedidos) {
            
            Transaction::open("database");

            $array = $file;

            $array["id_pedidos"] = $id_pedidos;


            echo "<pre>";
            print_r($array);
            echo "</pre>";

            $table = new Arquivos;            
            
            if(isset($table->id)) {

                // Já existe no banco de dados

                $update = $table->load($id);
                $update->fromArray($array);
                $update->store();
                

            }else {

                //Não existe no banco de dados
                $table->fromArray($array);
                $table->store();
            }

            

            Transaction::close();

            header("location:http://localhost/usando_a_api_da_empresa_stokki/app/?class=Stokki_pedidos&method=allOrders");

        }



    }



?>