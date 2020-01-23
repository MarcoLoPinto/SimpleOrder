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
                <p class="logo-name">Errore</p>
            </div>
            <!-- SVG separator -->
            <div class="">
                <svg x="0" y="0" viewBox="0 0 1000 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="top-box-svg-color" points="0 0 1000 0 1000 100" ></polygon>
                </svg>
            </div>
        </div>

    </div>

    <div class="content column-aligned">

        <p class="text-centered">Servizio non disponibile, riprova tra un p&ograve;&nbsp;<a href="./index.php" class="primary-color">qui</a></p>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>