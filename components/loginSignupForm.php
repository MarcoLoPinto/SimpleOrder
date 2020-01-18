<?php

    if (isset($_POST['login'])) { //$_POST['elementName']
        if(!isset($_SESSION)) session_start();
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES | ENT_SUBSTITUTE | ENT_XHTML, "", true); // xss sanitize
        $name = mysqli_real_escape_string($mysqliConnection, $name); // sql sanitize
    
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        $password = mysqli_real_escape_string($mysqliConnection, $_POST['password']);
        //dati inviati
        if (empty($_POST['name']) || empty($_POST['password'])) {
            $loginError = "Dati per il login mancanti";
        } else {
            //controllo se i dati esistono nel database...
            $queryResult = mysqli_query(
                $mysqliConnection,
                            "SELECT *
                            FROM tableOrder
                            WHERE name = '$name' AND password ='$password' "
            );
            //Siamo arrivati al punto in cui la query ha prodotto risultato:
            //il DB allora dovrà rilasciare solo una riga con quell'name+pass (altrimenti non sarebbe corretto!)
            $row = mysqli_fetch_array($queryResult);
            if ($row) {
                $_SESSION['login'] = true;
                $_SESSION['id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
            } 
            else 
                $loginError = "Questo nome/password non è corretto";
        }
    }

?>