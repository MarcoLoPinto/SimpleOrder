<?php
    require_once("../components/xmlMode.html");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>DB Installer v 4.0 Ultra Deluxe</title>
    </head>

    <body>
        <h3>Creazione del DataBase e popolazione</h3>

        <?php
            error_reporting(E_ALL); //tutti
            //error_reporting(0);
            //Mi connetto al DB...
            require_once("../components/dbVariables.php");

            //Connessione al DB
            $mysqliConnection = new mysqli($db_ip, $db_connection_name, $db_connection_pass);
            //Check della connessione...
            if(mysqli_connect_errno($mysqliConnection)) {
                echo "<p>Problemi con la connessione al db, errore/i: ".mysqli_connect_error()." (magari user/pass errati?)</p>";
                exit();
            }

            //drop del database (usato nel debug)
            $queryResult = mysqli_query($mysqliConnection, "DROP DATABASE $db_name");
            if($queryResult){
                echo "<p>Database droppato con nome: ".$db_name."</p>";
            }
            else {
                echo "<p>Drop database non riuscito, provo a crearlo lo stesso...</p>";
            }

            //Creiamo il nostro mondo...
            $queryResult = mysqli_query($mysqliConnection, "CREATE DATABASE $db_name");
            if($queryResult){
                echo "<p>Database creato con nome: ".$db_name."</p>";
            }
            else {
                echo "<p>Errore creazione database</p>";
                exit();
            }
            
            //Chiudiamo la connessione per poter poi creare tabelle e popolarle...
            $mysqliConnection->close();

            require_once("../components/dbConnection.php");
            //Creo il mondo...

            //Importo mysqli_execute_multiple_queries()
            require_once("../components/functions.php");

            //Creiamo il nostro mondo...
            $file = file_get_contents('./database_scheme.sql', true);
            $queryResult = mysqli_multi_query($mysqliConnection, $file);
            if(mysqli_execute_multiple_queries($queryResult,$mysqliConnection)){
                echo "<p>Database ".$db_name." riempito con le tabelle</p>";
            }
            else {
                echo "<p>Errore creazione tabelle nel database: ".mysqli_error($mysqliConnection)."</p>";
                exit();
            }

            //Popoliamo...
            $file = file_get_contents('./database_populate.sql', true);
            $queryResult = mysqli_multi_query($mysqliConnection, $file);
            if (mysqli_execute_multiple_queries($queryResult,$mysqliConnection))
                echo "<p>Popolamento riuscito!</p>";
            else {
                echo "<p>Popolamento non riuscito, errore: ".mysqli_error($mysqliConnection)."</p>";
                exit();
            }


            //Chiudiamo la connessione
            $mysqliConnection->close();
            
        ?>
    </body>

</html>