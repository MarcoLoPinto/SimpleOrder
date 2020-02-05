<?php
$error = NULL;
//Sono connesso gia?

//Mi connetto al DB per il FORM...
require_once("./components/dbVariables.php");
require_once("./components/dbConnection.php");
session_start();

require_once("./components/checkSession.php");
$checkTypeSession('admin');
?>

<?php
require_once("./components/xmlMode.html");
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8">
    <title>SimpleOrder</title>
    <link rel="stylesheet" type="text/css" href="./CSS/page.css">
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

        <div class="card row-aligned">
            <div class="card-left">
                <p class="card-genere">Crea/elimina un tavolo</p>
            </div>
            <div class="card-right">
                <a class="button-form" href="./createTables.php">Vai</a>
            </div>
        </div>

        <div class="card row-aligned">
            <div class="card-left">
                <p class="card-genere">Genera conto</p>
            </div>
            <div class="card-right">
                <a class="button-form" href="./checkTables.php">Vai</a>
            </div>
        </div>

        <div class="card row-aligned">
            <div class="card-left">
                <p class="card-genere">Tavoli liberi ed occupati</p>
            </div>
            <div class="card-right">
                <a class="button-form" href="./freeTables.php">Vai</a>
            </div>
        </div>

        <div class="card row-aligned">
            <div class="card-left">
                <p class="card-genere">Ordini</p>
            </div>
            <div class="card-right">
                <a class="button-form" href="./orderTables.php">Vai</a>
            </div>
        </div>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>