<?php
$error = NULL;
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

        <div class="row-aligned">
            <p class="">Aggiorna ogni</p>
            <input type="number" id="secondsTime" class="input-login" value="15" min="2" step="1" />
            <p class="">secondi</p>
            <input type="submit" id="secondsButton" class="button-form" name="invio" value="Set" />
        </div>
        
        <div id="orders">
            <?php //echo $getOrders() ?>
        </div>

    </div>

    <?php require("./components/footer.html"); ?>

    <script>
        window.onload = function(){
            var time = 15;

            var pollingOrders = () => fetch(`./API/orders.php`)
                .then(function(response) {
                    return response.json();
                })
                .then(function(ordersList) {
                    let ordersHTML = document.getElementById("orders");
                    ordersHTML.innerHTML = ordersList;

                    setTimeout(pollingOrders,time*1000);
                });
            
            pollingOrders();

            function isPositiveInteger(n) {
                return n >>> 0 === parseFloat(n);
            }

            document.getElementById("secondsButton").addEventListener("click", function(){
                let secs = document.getElementById("secondsTime").value;
                if(isPositiveInteger(secs)){
                    time = secs;
                }
            });
        }
    </script>

</body>

</html>