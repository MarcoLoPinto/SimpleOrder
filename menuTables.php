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

if(isset($_POST["deleteCategory"])){
    $id = (int)$_POST["idCategory"];
    if($deleteCategory($id)){
        $response = "Categoria eliminata con successo";
    } else {
        $response = "Impossibile eliminare la categoria";
    }
}
else if(isset($_POST["createCategory"])){
    $name = $_POST["categoryName"];
    if($createCategory($name)){
        $response = "Categoria creata con successo";
    } else {
        $response = "Impossibile creare la categoria";
    }
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
                <p class="logo-name top-box-element-centered">Gestione</p>
            </div>
        </div>

    </div>

    <div class="content column-aligned">

        <p class="text-centered"><a href="./adminPanel.php" class="primary-color">Torna indietro</a></p>

        <form method="post" action="<?php $_SERVER['PHP_SELF']?>" class="column-centered center-margin">
            <input type="text" class="input-login" name="categoryName" placeholder="nome categoria" required />
            <p><input type="submit" class="button-form" name="createCategory" value="Genera" /><input type="reset" class="button-form" value="Reset" /></p>
        </form>

        <hr class="hr-primary-color" />

        <?php 
            print_r($getMenuAdmin());
            require_once("./components/modal.php");
            if($response != NULL) $generateModal("mod",$response);
        ?>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>