<?php
    require_once(__DIR__."/functions.php");
    require_once(__DIR__."/dbVariables.php");
    require_once(__DIR__."/dbConnection.php");

    $getMenu = function() use ($mysqliConnection){
        $arr = Array();
        $html = "";

        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *, f.id as idFood
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

        foreach($arr as $foodtype=>$v){
            $html .= '
                    <div>
                        <p class="primary-color text-title">'.$foodtype.'</p>
                        <hr class="hr-primary-color" />
                        <div class="table">';
                foreach($arr[$foodtype] as $ki=>$food){
                    $html .= '
                            <form method="post" action="'.$_SERVER['PHP_SELF'].'" class="">
                                <div class="row">
                                    <strong class="value">'.$food["name"].'</strong>
                                    <div class="dots"></div>
                                    <div class="value">'.$food["price"].'$ x</div>
                                    <p class="value">
                                        <input type="hidden" name="idOrder" value="'.$food["idFood"].'" />
                                        <input type="number" class="quantity" name="quantity" min="1" max="99" value="1" />
                                        <input type="submit" class="order-button" name="ordine" value="Ordina" />
                                    </p>
                                </div>
                                <p class="order-description">'.(($food["description"]=="")?"&nbsp;":$food["description"]).'</p>
                            </form>';
                }
            $html .= '  
                        </div>
                    </div>';

        }

        return $html;
    };

    $addToCart = function($idFood,$quantity,$idUser) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "INSERT INTO foodInstance (quantity, id_food, id_tableOrder)
                    VALUES
                        ('".$quantity."', '".$idFood."','".$idUser."');");
    };
?>