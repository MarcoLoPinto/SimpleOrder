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

        <?php if(!isset($_GET["id"])){ ?>

            <p class="text-centered"><a href="./adminPanel.php" class="primary-color">Torna indietro</a></p>

            <p class="text-centered">
                *Solo i tavoli che sono occupati dai clienti potranno generare il conto.
            </p>
            
            <div class="column-centered center-margin">
                <input type="text" id="searchBar" class="input-login" placeholder="cerca tavolo..." />
            </div>
            
            <div class="">
                <?php echo $getTablesInfo(); ?>
            </div>

            <script src="./components/searchBar.js"></script>

            <?php 
                require_once("./components/modal.php"); 
                if($response != NULL) $generateModal("mod",$response);
            ?>
        <?php } else { ?>
            <p class="text-centered"><a href="./checkTables.php" class="primary-color">Torna indietro</a></p>

            <p class="text-centered">
                Tavolo: <?php echo $_GET["name"] ?>
            </p>

            <?php echo $getTableFoodsList($_GET["id"]); ?>
        
        <?php } ?>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>