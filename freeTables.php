<?php
$response = NULL;
//Sono connesso gia?

//Mi connetto al DB per il FORM...
require_once("./components/dbVariables.php");
require_once("./components/dbConnection.php");
session_start();

require_once("./components/checkSession.php");
$checkTypeSession('admin');

require_once("./components/menuFunctions.php");
if(isset($_POST["produceTakenTable"])){ //occupa il tavolo
    if($generateNewPassword($_POST["idTable"])){ //genera la password nuova
        $removeOrdersFromTable($_POST["idTable"]); //elimina tutti gli alimenti dal carrello del tavolo
        $table = $getTableInfo($_POST["idTable"]); //ottiene le info del tavolo
        if($table != NULL){
            $response = "Nome tavolo: ".$table["name"]."<br>Password: ".$encrypt_decrypt($table["password"],'d');
            if(!$setTableisTaken($_POST["idTable"],1)) $response = "Impossibile occupare tavolo";
        } else $response = "Tavolo non esistente";
    } else $response = "Impossibile generare nuova password per il tavolo";
} 
else if(isset($_POST["produceFreeTable"])){ //libera il tavolo
    if($setTableisTaken($_POST["idTable"],0)) $response = "Tavolo reso disponibile";
    else $response = "Impossibile liberare tavolo";
}
?>

<?php
require_once("./components/xmlMode.html");
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <title>SimpleOrder</title>
    <link rel="stylesheet" type="text/css" href="./CSS/page.css">
    <link rel="stylesheet" type="text/css" href="./CSS/modal.css">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <link rel="icon" href="./imgs/logo.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>

<body>

    <div class="top-bar">

        <div class="top-box">
            <div class="row-aligned top-box-color top-box-padding">
                <p><a href="./logout.php" class="top-box-text">Logout</a></p>
                <p class="logo-name top-box-element-centered">Gestione</p>
            </div>
        </div>

    </div>

    <div class="content responsive-content">

        <p class="text-centered"><a href="./adminPanel.php" class="primary-color">Torna indietro</a></p>

        <p class="text-centered">
            Premendo "Usa" su un tavolo, si genera una nuova password per quel
            tavolo, cos&igrave; da poter essere usato da un nuovo cliente (mostrando la password)
        </p>

        <h2 class="text-centered">Tavoli liberi</h2>

        <div class="">
            <?php echo $getFreeTables(); ?>
        </div>

        <hr class="hr-primary-color" />

        <p class="text-centered">
            Premendo "Rimuovi" su un tavolo, quest'ultimo non sar&agrave; pi&ugrave; occupato
        </p>

        <h2 class="text-centered">Tavoli occupati</h2>

        <div class="">
            <?php echo $getTakenTables(); ?>
        </div>

        <?php 
            require_once("./components/modal.php"); 
            if($response != NULL) $generateModal("mod",$response);
        ?>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>