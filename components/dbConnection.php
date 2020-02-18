<?php
    //connessione...
    $mysqliConnection = new mysqli($db_ip, $db_connection_name, $db_connection_pass, $db_name);

    //controllo della connessione
    if (mysqli_connect_errno($mysqliConnection)) {
        header("Location: errorConnection.php");
        //printf("Errore connessione al db: %s\n", mysqli_connect_error($mysqliConnection));
        exit();
    }
?>