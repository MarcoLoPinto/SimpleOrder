<?php
    require_once(__DIR__."/profileFunctions.php");

    if(!isset($_SESSION)) session_start(); //da qui in poi qualsiasi pagina navigo avro' le mie variabili salvate in $_SESSION
    if(!isset($_SESSION['login'])){
        header('LOCATION:index.php');
        exit();
    }
?>