<?php
$response = NULL;
//Sono connesso gia?

//Mi connetto al DB per il FORM...
require_once("./components/dbVariables.php");
require_once("./components/dbConnection.php");
session_start();

require_once("./components/checkSession.php");
$checkTypeSession('admin');
$idFood = $_GET["id"];
if(!isset($idFood)){
    header('LOCATION:adminPanel.php');
    exit();
}

require_once("./components/menuFunctions.php");
if(isset($_POST["editFood"])){
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = (int)$_POST["price"];

    if($editFood($idFood,$name,$description,$price)){
        $response = "Piatto modificato con successo";
    } else {
        $response = "Impossibile modificare il piatto";
    }
} else if(isset($_POST["deleteFood"])){
    if($deleteFood($idFood)){
        $response = "Piatto eliminato con successo";
    } else {
        $response = "Impossibile eliminare il piatto";
    }
}

$food = $getFoodInfo($idFood);
$foodName = ($food!=NULL)?$food["name"]:"";
$foodPrice = ($food!=NULL)?(int)$food["price"]:"";
$foodDescription = ($food!=NULL)?$food["description"]:"";
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

        <p class="text-centered"><a href="./menuTables.php" class="primary-color">Torna indietro</a></p>

        <h2 class="text-centered">Modifica piatto</h2>

        <form method="post" action="<?php $_SERVER['PHP_SELF']?>" class="column-centered center-margin">
            <input type="text" class="input-login" name="name" placeholder="nome piatto" required value="<?php echo $foodName ?>" />
            <input type="text" class="input-login" name="description" placeholder="descrizione" required value="<?php echo $foodDescription ?>" />
            <input type="number" class="input-login" name="price" placeholder="prezzo" min="0" required value="<?php echo $foodPrice ?>" />
            <p><input type="submit" class="button-form" name="editFood" value="Modifica" /><input type="submit" class="button-form" name="deleteFood" value="Elimina" /></p>
        </form>

        <?php 
            require_once("./components/modal.php"); 
            if($response != NULL) $generateModal("mod",$response);
        ?>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>