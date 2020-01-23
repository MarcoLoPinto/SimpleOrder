<?php
    require_once(__DIR__."/functions.php");
    require_once(__DIR__."/dbVariables.php");
    require_once(__DIR__."/dbConnection.php");

    $getMenu = function() use ($mysqliConnection){
        $arr = Array();

        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM food f, category c
                    WHERE f.id_category = c.id
                    ORDER BY c.id;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k => $food){
                if(!array_key_exists($food["type"],$arr)) $arr[$food["type"]] = Array();
                array_push($arr[$food["type"]],$food);
            }
        }

        return $arr;
    };
?>