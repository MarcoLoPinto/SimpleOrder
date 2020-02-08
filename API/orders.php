<?php 

    require_once("../components/menuFunctions.php");
    header('Content-Type: application/json');

    session_start();

    if(!isset($_SESSION) || $_SESSION["type"] != "admin"){
        echo json_encode("");
        exit();
    }
    
    echo json_encode($getOrders());

?>