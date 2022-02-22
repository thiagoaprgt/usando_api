<?php

    require_once "library/Autoload.php";
    
    Autoload::activeDebugRequires(true);

    $al = new Autoload();

    $al->setDirectories("library");    
    $al->setDirectories("controllers");
    $al->setDirectories("controlers/pages");
       
    

    // Debugando o autoload

    Autoload::activeDebugRequires(true); 

    
    /*
        A função register() registra os arrays enviados pela funcão setDirectories,
        se a activeDebugRequires for true ele mostra todos os require_once feitos.
    */

    $register = $al->register();

    

    

    $content = "";
    $output = ""; 

        
    Stokki::setTest(true); // ao colocar true será usada a api_teste 

    $teste = Stokki::getTest();     


    Stokki::setDebugHeader(true); // ao colocar mostra o cabeçalho HTTP que enviado pelos métodos que fazem requisições

    $debuHeader = Stokki::getDebugHeader();


    

    $template = file_get_contents("templates/home.html");

    $template = str_replace("{{content}}", $content, $template);


    ob_start(); // gerenciador de output   


    $stokki = new Stokki_produtos;
   

    $output = ob_get_contents();


    ob_end_clean();



   



    if($teste == true) {

        $content = file_get_contents("templates/section/listarProdutos_teste.html");

    }else {

        $content = file_get_contents("templates/section/listarProdutos.html");

    }


    $content .=  $output;

    $template = file_get_contents("templates/home.html");

    $template = str_replace("{{content}}", $content, $template);

    echo $template;



    


?>