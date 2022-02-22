<?php


    require_once "../controllers/api.php";


    $authorization = Api::authorization();

    if($authorization == "Bearer token") {

        $api = new Api;

    }else{

        echo "Acesso negado";
       
    }

    




?>