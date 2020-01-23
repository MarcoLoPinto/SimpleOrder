<?php
    $checkTypeSession = function($pageFor){ //user or admin
        if(!isset($_SESSION) || !isset($_SESSION['login'])){
            header('LOCATION:index.php');
            exit();
        }
        else if(isset($_SESSION['login']) && isset($_SESSION['type']) && $_SESSION['type'] == 'user' && $pageFor == 'admin'){
            header('LOCATION:home.php');
            exit();
        } else if(isset($_SESSION['login']) && isset($_SESSION['type']) && $_SESSION['type'] == 'admin' && $pageFor == 'user'){
            header('LOCATION:adminPanel.php');
            exit();
        }
    };
?>