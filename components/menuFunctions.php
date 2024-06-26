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
                                    <div class="value">'.$food["price"].'&euro; x</div>
                                    <p class="value">
                                        <input type="hidden" name="idOrder" value="'.$food["idFood"].'" />
                                        <input type="hidden" name="foodOrder" value="'.$food["name"].'" />
                                        <input type="number" class="quantity" name="quantity" min="1" max="99" step="1" value="1" />
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
                    '<form method="post" action="'.$_SERVER['PHP_SELF'].'" class="card row-aligned" data-searchbar="'.$table["name"].'">
                        <div class="card-left">
                            <p class="card-genere">'.$table["name"].' ('.($table["isTaken"]?"occupato":"libero").')<br />
                            posti: '.$table["seats"].'</p>
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

    $getTablesInfo = function() use ($mysqliConnection,$encrypt_decrypt){
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
                    '<tr data-searchbar="'.$table["name"].'">
                        <td>'.$table["name"].'</td>
                        <td>'.$encrypt_decrypt($table["password"],'d').'</td>
                        <td>
                            <form method="get" action="'.$_SERVER['PHP_SELF'].'">
                                <input type="hidden" name="id" value="'.$table["id"].'" />
                                <input type="hidden" name="name" value="'.$table["name"].'" />
                                <input type="submit" class="button-form" value="Vai" '.($table["isTaken"]?"":"disabled").' />
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
                    '<form method="post" action="'.$_SERVER['PHP_SELF'].'" class="card row-aligned" data-searchbar="'.$table["name"].'">
                        <div class="card-left">
                            <p class="card-genere">'.$table["name"].', posti: '.$table["seats"].'</p>
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
                    '<form method="post" action="'.$_SERVER['PHP_SELF'].'" class="card row-aligned" data-searchbar="'.$table["name"].'">
                        <div class="card-left">
                            <p class="card-genere">'.$table["name"].', posti: '.$table["seats"].'</p>
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

    $generateNewPassword = function($id) use ($mysqliConnection,$random_str,$getTableInfo,$encrypt_decrypt){
        $table = $getTableInfo($id);
        if($table!=NULL && $table["isTaken"] == 0){
            $pass = $random_str();
            $encryped = $encrypt_decrypt($pass,'e');
            $queryResult = mysqli_query($mysqliConnection,
                        "UPDATE tableOrder
                        SET password = '".$encryped."'
                        WHERE id = '".$id."';");
            
            if ($queryResult) return true;
        }
        return false;
    };

    $getOrders = function() use ($mysqliConnection){
        $html = "";
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT f.name as name, fi.quantity as quantity, fi.time as time, t.name as tableName
                    FROM foodInstance fi, tableOrder t, food f
                    WHERE fi.id_tableOrder = t.id
                    AND fi.id_food = f.id
                    ORDER BY time DESC;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            foreach($res as $k=>$food){
                $html .= 
                    '<div class="minicard row-aligned">
                        <div class="column-aligned">
                            <h3 class="card-genere center-margin">Tavolo: '.$food["tableName"].' (x'.$food["quantity"].')</h3>
                            <p class="card-genere">'.$food["name"].'</p>
                        </div>
                        <div class="card-right">
                        <p class="card-genere">'.$food["time"].'</p>
                        </div>
                    </div>';
            }
        }
        return $html;
    };

    $getOrdersAPI = function() use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT f.name as name, fi.quantity as quantity, fi.time as time, t.name as tableName
                    FROM foodInstance fi, tableOrder t, food f
                    WHERE fi.id_tableOrder = t.id
                    AND fi.id_food = f.id
                    ORDER BY time DESC;");
        
        $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);
        if ($res){
            return $res;
        }
        return NULL;
    };

    $getMenuAdmin = function() use ($mysqliConnection){
        $arr = Array();
        $html = "";

        $queryCategory = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM category c
                    ORDER BY c.id;");
        $resCategory =  mysqli_fetch_all_php5($queryCategory, MYSQLI_ASSOC);
        
        //print_r($res);
        //print_r($resCategory);
        if ($resCategory){
            foreach($resCategory as $k => $category){
                $arr[$category["type"]] = Array();
                $arr[$category["type"]]["idCategory"] = $category["id"];
                $arr[$category["type"]]["content"] = Array();
                

                $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *, f.id as idFood
                    FROM food f, category c
                    WHERE f.id_category = c.id
                    AND c.id = ".$category["id"].";");
                $res =  mysqli_fetch_all_php5($queryResult, MYSQLI_ASSOC);

                //print_r($res);
                foreach($res as $k => $food){
                    array_push($arr[$category["type"]]["content"],$food);
                }

            }
        }

        foreach($arr as $foodtype=>$foods){
            $html .= '
                    <div>
                        <p class="primary-color text-title">'.$foodtype.'</p>
                        <hr class="hr-primary-color" />
                        <div class="table">';
                foreach($foods["content"] as $ki=>$food){
                    $html .= '
                            <form method="post" action="'.$_SERVER['PHP_SELF'].'" class="">
                                <div class="row">
                                    <strong class="value">'.$food["name"].'</strong>
                                    <div class="dots"></div>
                                    <div class="value">'.$food["price"].'&euro; &nbsp;</div>
                                    <p class="value">
                                        <a class="order-button" href="./editFood.php?id='.$food["idFood"].'">Modifica</a>
                                    </p>
                                </div>
                                <p class="order-description">'.(($food["description"]=="")?"&nbsp;":$food["description"]).'</p>
                            </form>';
                }
            $html .= '  
                        </div>
                        <form method="post" action="'.$_SERVER['PHP_SELF'].'" class="row-aligned">
                            <div class="">
                                <p class="value">
                                    <input type="hidden" name="idCategory" value="'.$foods["idCategory"].'" />
                                    <input type="submit" class="order-button" name="deleteCategory" value="Elimina Categoria" />
                                    <a class="order-button" href="./addInCategory.php?idCategory='.$foods["idCategory"].'&nameCategory='.$foodtype.'">Aggiungi alla Categoria</a>
                                </p>
                            </div>
                        </form>

                    </div>';

        }

        return $html;
    };

    $deleteCategory = function($id) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "DELETE FROM category
                    WHERE id = '".$id."';");

        if(!$queryResult){
            return false;
        }

        return true;
    };

    $createCategory = function($name) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "INSERT INTO category (type)
                    VALUES
                        ('".$name."');");

        //print_r(mysqli_error($mysqliConnection));
        if(!$queryResult){
            return false;
        }

        return true;
    };

    $addFoodToCategory = function($name,$description,$price,$idCategory) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "INSERT INTO food (name, price, id_category, description)
                    VALUES
                        ('".$name."','".$price."','".$idCategory."','".$description."');");

        //print_r(mysqli_error($mysqliConnection));
        if(!$queryResult){
            return false;
        }

        return true;
    };

    $getFoodInfo = function($id) use ($mysqliConnection){
        $queryResult = mysqli_query($mysqliConnection,
                    "SELECT *
                    FROM food f
                    WHERE f.id = '".$id."';");
        $res =  mysqli_fetch_array($queryResult, MYSQLI_ASSOC);
        if ($res){
            return $res;
        }
        return NULL;
    };

    $editFood = function($id,$name,$description,$price) use ($mysqliConnection){

        $queryResult = mysqli_query($mysqliConnection,
                    "UPDATE food
                    SET name = '".$name."',
                    price = '".$price."',
                    description = '".$description."'
                    WHERE id = '".$id."';");
        
        if ($queryResult) return true;
        
        return false;
    };

    $deleteFood = function($id) use ($mysqliConnection){

        $queryResult = mysqli_query($mysqliConnection,
                    "DELETE FROM food
                    WHERE id = '".$id."';");
        
        if ($queryResult) return true;
        
        return false;
    };

?>