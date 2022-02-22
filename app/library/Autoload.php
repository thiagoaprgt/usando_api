<?php

    class Autoload {

        private $directories;
        private $debugRequires = [];

        private static $activeDebugRequires = false;

        

        public function setDirectories(string $directory) {

            $this->directories[] = $directory;
        }  

        public function setDebugRequires(string $debugRequires) {
            $this->debugRequires[] = $debugRequires;
        }

        public function getDebugRequires() {

            if(self::$activeDebugRequires == true) {

                foreach($this->debugRequires as $debug) {
                    echo $debug . "<br>";
                }
                                
            }

            
        }

        public static function activeDebugRequires(bool $active) {
            self::$activeDebugRequires = $active;
        }

       


        
        public function getDirectories() {
            return $this->directories;
        }

        public function register() {

            
            spl_autoload_register(

                function() {

                    

                    foreach($this->directories as $dir) {

                        if(is_dir($dir) == true) {

                            // a função scandir escaneia o diretório e retorna um  array com os nomes dos arquivos encontrados.

                            $files = scandir($dir);

                            
                                                        
    
                            foreach($files as $file) {

                                // a função str_ends_with retorna true se a string terminar com o mesmo valor do segundo parâmetro.

                                $phpFile = str_ends_with($file, ".php");
                                


                                // a função str_contains retorna true se string conter a string com o mesmo valor do segundo parâmetro.

                                $subDirectories = str_contains($file, ".");
                                
    
                                if($file != "Autoload.php" && $phpFile == true) {
                                    
                                    $this->setDebugRequires(" require_once \"$dir/$file\"; ");
                                    
                                    require_once $dir . "/" . $file;

                                    
                                }else if($subDirectories == false) {

                                    // a função scandir escaneia o diretório e retorna um  array com os nomes dos arquivos encontrados.

                                    // echo "<br>Analisando subdiretórios: " . $dir . "/" . $file;

                                    /*
                                        Nesse casso o dir é diretório do primeiro foreach
                                        e o $file é o diretório do segundo foreach
                                        
                                    */

                                    
                                    $subDirectoriesFiles = scandir($dir . "/" . $file );

                                    
                                    /*
                                    echo "<pre>";
                                    print_r($subDirectoriesFiles);                                                                    
                                    echo "</pre>"; 
                                    */                                 
                                   

                                    foreach($subDirectoriesFiles as $arrayKey => $sdf) {

                                      
                                        // a função str_ends_with retorna true se a string terminar com o mesmo valor do segundo parâmetro.

                                        $phpFile = str_ends_with($sdf, ".php");

                                        if($phpFile == true) {

                                            /*                                        
                                                Nesse casso o dir é diretório do primeiro foreach,
                                                $file é o diretório do segundo foreach e o 
                                                $sdf é o arquivo.php                                        
                                            */

                                            $this->setDebugRequires(" require_once \"$dir/$file/$sdf\"; ");

                                            require_once $dir . "/" . $file . "/" . $sdf;

                                        }

                                            

                                        

                                    }

                                }
    
                            }
                            
                        }


                    }

                    $this->getDebugRequires(); 

                }

            );

            

        }

    }

?>