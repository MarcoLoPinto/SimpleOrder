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
            <div class="column-centered top-box-color top-box-padding">
                <p class="logo-name fade-in">Pannello di Controllo</p>
            </div>
        </div>

    </div>

    <div class="content column-aligned">

        <p class="text-centered">Pagina admin, esci da&nbsp;<a href="./logout.php" class="primary-color">qui</a></p>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>