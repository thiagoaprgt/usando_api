<?php

    require_once "library/Autoload.php";
    
    Autoload::activeDebugRequires(true);

    $al = new Autoload();

    $al->setDirectories("library");    
    $al->setDirectories("controllers");
    $al->setDirectories("controlers/pages");
       
    

    // Debugando o autoload

    Autoload::activeDebugRequires(false); 

    
    /*
        A função register() registra os arrays enviados pela funcão setDirectories,
        se a activeDebugRequires for true ele mostra todos os require_once feitos.
    */

    $register = $al->register();  

    $content = "";
    $output = ""; 


        
    Stokki::setTest(true); // ao colocar true será usada a api_teste 

    $teste = Stokki::getTest();     


    Stokki::setDebugHeader(false); // ao colocar mostra o cabeçalho HTTP que enviado pelos métodos que fazem requisições

    $debuHeader = Stokki::getDebugHeader();



    
    

    $template = file_get_contents("templates/home.html");

    $template = str_replace("{{content}}", $content, $template);


    $class = "Stokki_produtos";
    

    ob_start(); // gerenciador de output
    
    if( isset($_GET["class"]) && !empty($_GET["class"]) ) {

        $class = $_GET["class"];

    }

    $stokki = new $class;   

    $output = ob_get_contents();


    ob_end_clean();



   
    $content = $stokki::getContent();  


    $content .=  $output;

    $template = file_get_contents("templates/home.html");

    $template = str_replace("{{content}}", $content, $template);

    echo $template;



    


?>