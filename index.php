<?php
$error = NULL;
$loginError = NULL;
$signupError = NULL;
//Sono connesso gia?

//Mi connetto al DB per il FORM...
require_once("./components/dbVariables.php");
require_once("./components/dbConnection.php");
//Connessi, ora procediamo con la query per il login o signup se necessaria...
require_once("./components/loginSignupForm.php");

if(!isset($_SESSION)) session_start(); //da qui in poi qualsiasi pagina navigo avro' le mie variabili salvate in $_SESSION

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
    <!--
            Importato il font Roboto, per maggiore chiarezza nella
            lettura del sito (font usato in Android)
        -->
</head>

<body>

    <?php echo isset($error) ? "<div class=\"error\">" . $error . "</div>" : ""; ?>

    <div class="top-bar">

        <div class="row-aligned">
            <img src="./imgs/logo.ico" alt="logo" height="30px">
            <p class="">SimpleOrder</p>
        </div>

        <div class="top-box">
            <!-- SVG separator -->
            <div class="">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="svg-color" points="2560 0 2560 100 0 100" ></polygon>
                </svg>
            </div>
        </div>

    </div>

    <div class="content">

        

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>