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

    $random_str = function($length){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    };

    $encrypt_decrypt = function( $string, $action = 'e' ){
        $secret_key = 'ha$h3d_k3Y';
        $secret_iv = 'iV$hed3_k3y';
     
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
     
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
     
        return $output;
    };

?>