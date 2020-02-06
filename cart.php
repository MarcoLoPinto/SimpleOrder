<?php
$response = NULL;
//Sono connesso gia?

//Mi connetto al DB per il FORM...
require_once("./components/dbVariables.php");
require_once("./components/dbConnection.php");
session_start();

require_once("./components/checkSession.php");
$checkTypeSession('user');

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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <link rel="icon" href="./imgs/logo.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>

<body>

    <div class="top-bar">

        <div class="top-box">
            <div class="row-aligned top-box-color top-box-padding">
                <p><a href="./logout.php" class="top-box-text">Logout</a></p>
                <p class="logo-name top-box-element-centered">Spesa</p>
                <a class="container-top-box-icon" href="./cart.php">
                    <i class="material-icons top-box-icon">shopping_cart</i>
                    <strong class="elements-in-cart"><?php echo $getNumberFoodsFromCart($_SESSION["id"]); ?></strong>
                </a>
            </div>
        </div>

    </div>

    <div class="content responsive-content">
        <p class="text-centered"><a href="./home.php" class="primary-color">Torna agli ordini</a></p>

        <p class="text-centered">
            Sei il tavolo: <?php echo $_SESSION["name"] ?>
        </p>

        <?php echo $getTableFoodsList($_SESSION["id"]); ?>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>