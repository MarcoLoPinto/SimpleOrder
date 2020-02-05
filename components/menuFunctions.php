<?php
    require_once(__DIR__."/functions.php");
    require_once(__DIR__."/dbVariables.php");
    require_once(__DIR__."/dbConnection.php");

    $random_str = function(
        $length
    ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    };

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
                                    <div class="value">'.$food["price"].'&euro; x</div>
                                    <p class="value">
                                        <input type="hidden" name="idOrder" value="'.$food["idFood"].'" />
                                        <input type="hidden" name="foodOrder" value="'.$food["name"].'" />
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

        if(!$queryResult){
            return false;
        }

        return true;
    };

    $getNumberFoodsFromCart = function($idTable) use ($mysqliConnection){
        $quantity = 0;
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM foodInstance f
                    WHERE f.id_tableOrder = '".$idTable."';");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k=>$fi){
                $quantity += $fi["quantity"];
            }
        }
        return $quantity;
    };

    $getTableFoodsList = function($idTable) use ($mysqliConnection){
        $total = 0;
        $html = "";
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT f.name as name, fi.quantity as quantity, f.price as price
                    FROM foodInstance fi, food f
                    WHERE fi.id_tableOrder = '".$idTable."'
                    AND f.id = fi.id_food;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k=>$fi){
                $html .= 
                    '<div class="row">
                        <strong class="value">'.$fi["name"].' (x'.$fi["quantity"].')</strong>
                        <div class="dots bottom-dots"></div>
                        <div class="value">'.$fi["price"].' &euro;</div>
                    </div>';

                $total += $fi["price"];
            }
            if($html != ""){
                $html .= 
                    '<hr class="hr-primary-color" />

                    <div class="row">
                        <strong class="value">Totale</strong>
                        <div class="dots bottom-dots"></div>
                        <div class="value">'.$total.' &euro;</div>
                    </div>';
            }
        }

        return $html;
    };

    $getTables = function() use ($mysqliConnection){
        $html = "";
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM tableOrder;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k=>$table){
                $html .= 
                    '<form method="post" action="'.$_SERVER['PHP_SELF'].'" class="card row-aligned">
                        <div class="card-left">
                            <p class="card-genere">'.$table["name"].' ('.($table["isTaken"]?"occupato":"libero").')</p>
                        </div>
                        <div class="card-right">
                            <input type="hidden" name="idTable" value="'.$table["id"].'" />
                            <input type="submit" class="button-form" name="deleteTable" value="Elimina" />
                        </div>
                    </form>';
            }
        }
        return $html;
    };

    $deleteTable = function($id) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "DELETE FROM tableOrder
                    WHERE id = '".$id."';");

        if(!$queryResult){
            return false;
        }

        return true;
    };

    $removeOrdersFromTable = function($id) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "DELETE FROM foodInstance
                    WHERE id_tableOrder = '".$id."';");

        if(!$queryResult){
            return false;
        }

        return true;
    };

    $getTablesInfo = function() use ($mysqliConnection){
        $html = 
            '<table>
                <tr>
                    <th>Nome</th>
                    <th>Password</th>
                    <th>Genera Conto*</th>
                </tr>';
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM tableOrder;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k=>$table){
                $html .= 
                    '<tr>
                        <td>'.$table["name"].'</td>
                        <td>'.$table["password"].'</td>
                        <td>
                            <form method="post" action="'.$_SERVER['PHP_SELF'].'">
                                <input type="hidden" name="idTable" value="'.$table["id"].'" />
                                <input type="submit" class="button-form" name="resetTable" value="Vai" '.($table["isTaken"]?"":"disabled").' />
                            </form>
                        </td>
                    </tr>';
            }
        }
        $html .= 
            '</table>';
        return $html;
    };

    $getFreeTables = function() use ($mysqliConnection){
        $html = "";
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM tableOrder
                    WHERE isTaken = 0;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k=>$table){
                $html .= 
                    '<form method="post" action="'.$_SERVER['PHP_SELF'].'" class="card row-aligned">
                        <div class="card-left">
                            <p class="card-genere">'.$table["name"].'</p>
                        </div>
                        <div class="card-right">
                            <input type="hidden" name="idTable" value="'.$table["id"].'" />
                            <input type="submit" class="button-form" name="produceTakenTable" value="Usa" />
                        </div>
                    </form>';
            }
        }
        return $html;
    };

    $getTakenTables = function() use ($mysqliConnection){
        $html = "";
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM tableOrder
                    WHERE isTaken = 1;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k=>$table){
                $html .= 
                    '<form method="post" action="'.$_SERVER['PHP_SELF'].'" class="card row-aligned">
                        <div class="card-left">
                            <p class="card-genere">'.$table["name"].'</p>
                        </div>
                        <div class="card-right">
                            <input type="hidden" name="idTable" value="'.$table["id"].'" />
                            <input type="submit" class="button-form" name="produceFreeTable" value="Rimuovi" />
                        </div>
                    </form>';
            }
        }
        return $html;
    };

    $getTableInfo = function($id) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM tableOrder
                    WHERE id = '".$id."';");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res) return $res[0];
        return NULL;
    };

    $setTableisTaken = function($id,$isTaken) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "UPDATE tableOrder
                    SET isTaken = ".$isTaken."
                    WHERE id = '".$id."';");
        
        if ($queryResult) return true;
        return false;
    };

    $generateNewPassword = function($id) use ($mysqliConnection,$random_str,$getTableInfo){
        $table = $getTableInfo($id);
        if($table!=NULL && $table["isTaken"] == 0){
            $pass = $random_str(8);
            $queryResult = mysqli_query($mysqliConnection,
                        "UPDATE tableOrder
                        SET password = '".$pass."'
                        WHERE id = '".$id."';");
            
            if ($queryResult) return true;
        }
        return false;
    };

    $getFoodsList = function() use ($mysqliConnection){
        $html = "";
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM foodInstance;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            //TODO
        }
    };
?>