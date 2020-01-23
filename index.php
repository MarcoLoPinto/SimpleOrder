<?php
$error = NULL;
//Sono connesso gia?

//Mi connetto al DB per il FORM...
require_once("./components/dbVariables.php");
require_once("./components/dbConnection.php");
session_start();

if(isset($_SESSION['login']) && isset($_SESSION['type']) && $_SESSION['type'] == 'user'){
    header('LOCATION:home.php');
    exit();
} else if(isset($_SESSION['login']) && isset($_SESSION['type']) && $_SESSION['type'] == 'admin'){
    header('LOCATION:adminPanel.php');
    exit();
}

if(isset($_POST["invio"])){
    if (empty($_POST['name']) || empty($_POST['password'])){
        $error = "Nome e/o password mancanti";
    } else {
        //controllo se i dati esistono nel database...
        $escapedName = mysqli_real_escape_string($mysqliConnection,$_POST['name']);
        $escapedPassword = mysqli_real_escape_string($mysqliConnection,$_POST['password']);
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM tableOrder
                    WHERE name = '".$escapedName."' AND password ='".$escapedPassword."'");
        
        //Siamo arrivati al punto in cui la query ha prodotto risultato:
        //il DB allora dovrà rilasciare solo una riga con quell'user+pass (altrimenti non sarebbe corretto!)
        $row = mysqli_fetch_array($queryResult);
        if ($row){
            $_SESSION['login'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['type'] = 'user';

            header("Location: home.php");   //accesso alla pagina iniziale
            exit();
        } else $error = "Nome e/o password errati!";
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
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <link rel="icon" href="./imgs/logo.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>

<body>

    <div class="top-bar">

        <div class="top-box">
            <div class="column-centered top-box-color top-box-padding">
                <!-- Icon made by Freepik from www.sefsfs.com -->
                <img class="logo" src="./imgs/logo.ico" alt="logo">
                <p class="logo-name fade-in">SimpleOrder</p>
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

        <form method="post" action="<?php $_SERVER['PHP_SELF']?>" class="column-centered">
            <input type="text" class="input-login" name="name" placeholder="nome tavolo" required />
            <input type="password" class="input-login" name="password" placeholder="password"  required />
            <p><input type="submit" class="button-form" name="invio" value="Login" /><input type="reset" class="button-form" value="Reset" /></p>
        </form>

        <?php echo isset($error) ? "<div class=\"error\">" . $error . "</div>" : ""; ?>

        <p class="text-centered">Sei admin? Accedi&nbsp;<a href="./admin.php" class="primary-color">qui</a></p>

    </div>

    <?php require("./components/footer.html"); ?>

</body>

</html>