<?php

    function mysqli_fetch_all_php5($mysqli_query_res,$type = 1){
        $res = array();
        
        while( $row = mysqli_fetch_array($mysqli_query_res, $type) ){
            $res[] = $row;
        }
    
        return $res;
    }

    function mysqli_execute_multiple_queries($queryResult,$mysqliConnection){
        $no_errors = true;
        if ($queryResult) {
            do {
                // grab the result of the next query
                if (($queryResult = mysqli_store_result($mysqliConnection)) === false && mysqli_error($mysqliConnection) != '') {
                    echo "Query failed: " . mysqli_error($mysqliConnection);
                    $no_errors = false;
                }
            } while (mysqli_more_results($mysqliConnection) && mysqli_next_result($mysqliConnection)); // while there are more results
        } else {
            echo "First query failed..." . mysqli_error($mysqliConnection);
            $no_errors = false;
        }
        return $no_errors;
    }

    function startsWith($string, $startString){
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    } 

    //restituisce l'url del file (senza esso): controlla che protocollo usiamo attraverso HTTPS di server oppure se viene usata la porta 443
    function getUrlPath(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $array = explode("/",$_SERVER["PHP_SELF"]);
        $array[count($array)-1] = "";
        $path = join("/",$array);
        $url = $protocol.$_SERVER["HTTP_HOST"].$path;
        return $url;
    }



?>