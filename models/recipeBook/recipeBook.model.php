<?php
require_once "../../utils/jwt.php";


class recipeBook extends Connection
{

    public static function exectQuery($sentQuery)
    {
        $db = new Connection();
        $resultQuery = $db->query($sentQuery);
        return $resultQuery;
    }

    public static function exectQueryOne($sentQuery)
    {
        $db = new Connection();
        $resultQuery = $db->query($sentQuery);
        $result = $resultQuery->fetch_array()[0] ?? "";
        return $result;
    }

    public static function printData($resultado)
    {
        $datos = [];
        if ($resultado->num_rows) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idRecipeBook' => $row['idRecipeBook'],
                    'recipeBookName' => $row['recipeBookName'],
                    'performance' => $row['performance'],
                    'descriptionRecipe' => $row['descriptionRecipe'],
                    'img' => $row['img'],
                    'url' => $row['url'],
                    'creationDate' => $row['creationDate'],
                    'updateDate' => $row['updateDate'],
                    'idAuth' => $row['idAuth'],
                ];
            }
            return $datos;
        }
        return $datos;
    }


    public static function globalService($sentQuery, $idAuth, $all, $joinQuery = false)
    {
        $secret_key = 'passAuth';
        $cabezera = getallheaders();
        $token = $cabezera["Authorization"];


        if ($token) {
            $query2 = AuthNew::Check($token, $secret_key);
            $idAuthVerify = get_object_vars($query2)["idAuth"];

            if ($idAuthVerify == $idAuth) {
                return self::exectQuery($sentQuery);
            } else if ($joinQuery == TRUE) {
                $sentQuery .= $idAuthVerify;
                return self::exectQuery($sentQuery);
            } else if ($all == TRUE) {
                return self::exectQuery($sentQuery);
            } else if ($idAuth == null) {
                return FALSE;
            } else {
                echo "You do not have the necessary permissions  ,";
            }
        } else {
            echo "the request does not have a token   ";
        }
    }

    public static function insertRecipeBook($recipeBookName, $performance, $descriptionRecipe, $img, $url, $idAuth)
    {
        if (($recipeBookName && $performance && $descriptionRecipe && $img && $url && $idAuth)) {

            $sentQuery = "INSERT INTO recipeBook (recipeBookName,performance,descriptionRecipe,img,url,idAuth)
                    VALUES('" . $recipeBookName . "', '" . $performance . "', '" . $descriptionRecipe . "','" . $img . "','" . $url . "','" . $idAuth . "')";
            return self::globalService($sentQuery, $idAuth, FALSE);
        } else {
            return false;
        }
    }

    public static function updateRecipeBook($idRecipeBook, $recipeBookName, $performance, $descriptionRecipe, $img, $url, $idAuth)
    {
        if (($recipeBookName && $performance && $descriptionRecipe && $img && $url && $idAuth)) {

            $query2 = "SELECT idAuth FROM recipeBook WHERE idRecipeBook='{$idRecipeBook}'";
            $result = self::exectQueryOne($query2);

            if ($result) {
                $sentQuery = "UPDATE recipeBook SET
                      recipeBookName='" . $recipeBookName . "', performance='" . $performance . "', descriptionRecipe='" . $descriptionRecipe . "',img='" . $img . "',  url='" . $url . "', idAuth='" . $idAuth . "' 
                      WHERE idRecipeBook=$idRecipeBook";
                return self::globalService($sentQuery, $idAuth, FALSE);
            } else {
                return FALSE;
            }
        }
    }

    public static function deleteRecipeBook($idRecipeBook)
    {
        $query2 = "SELECT idAuth FROM recipeBook WHERE idRecipeBook='{$idRecipeBook}'";
        $result = self::exectQueryOne($query2);

        $sentQuery = "DELETE FROM recipeBook WHERE idRecipeBook='{$idRecipeBook}'";
        return self::globalService($sentQuery, $result, FALSE);
    }


    public static function getAllRecipeBook()
    {
        $sentQuery = "SELECT * FROM recipeBook";
        $resultado = self::globalService($sentQuery, null, TRUE);
        return self::printData($resultado);
    }


    public static function getYourRecipeBook()
    {
        $sentQuery = "SELECT * from recipeBook where idAuth=";
        $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
        return self::printData($resultado);
    }

    public static function byIdRecipeBook($idRecipeBook): array
    {
        $sentQuery = "SELECT *FROM recipeBook WHERE idRecipeBook=$idRecipeBook";
        $resultado = self::globalService($sentQuery, null, TRUE);
        return self::printData($resultado);
    }


    public static function getCompleteRecipeBook($idRecipeBook)
    {
        $query2 = "SELECT idAuth FROM recipeBook WHERE idRecipeBook='{$idRecipeBook}'";
        $result = self::exectQueryOne($query2);

        $sentQuery = "SELECT re.recipeBookName, he.headerName,re.img, re.url, re.creationDate, re.updateDate, pr.ingredientDatail, pr.percentage, pr.quantityPounds, pr.quantityOunces, re.performance
                    FROM ingredientRecipeBook pr
                    JOIN headerIngredientRecipeBook he 
                    ON pr.idHeaderIngredientRecipeBook =he.idHeaderIngredientRecipeBook 
                    JOIN recipeBook re  
                    ON re.idRecipeBook=he.idRecipeBook
                    WHERE re.idRecipeBook='{$idRecipeBook}'";

        $sentQuery2 = "SELECT he.headerProcedure, pr.procedureRecipeBookStep
                    FROM headerProcedureRecipeBook he
                    JOIN procedureRecipeBook pr 
                    ON he.idHeaderProcedureRecipeBook =pr.idHeaderProcedureRecipeBook
                    JOIN recipeBook re  
                    ON re.idRecipeBook=he.idRecipeBook
                    WHERE re.idRecipeBook='{$idRecipeBook}'";

        $sentQuery3 = "SELECT descriptionRecipe FROM recipeBook  WHERE idRecipeBook='{$idRecipeBook}'";

        $resultado = self::globalService($sentQuery, $result, FALSE);
        $resultado2 = self::globalService($sentQuery2, $result, FALSE);
        $resultado3 = self::globalService($sentQuery3, $result, FALSE);

        $datos = [];

        if ($resultado) {
            if ($resultado->num_rows) {
                while ($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'recipeBookName' => $row['recipeBookName'],
                        'headerName' => $row['headerName'],
                        'img' => $row['img'],
                        'url' => $row['url'],
                        'creationDate' => $row['creationDate'],
                        'updateDate' => $row['updateDate'],
                        'ingredientDatail' => $row['ingredientDatail'],
                        'percentage' => $row['percentage'],
                        'quantityPounds' => $row['quantityPounds'],
                        'quantityOunces' => $row['quantityOunces'],
                        'performance' => $row['performance'],

                    ];
                }
                if ($resultado2) {
                    if ($resultado2->num_rows) {
                        while ($row = $resultado2->fetch_assoc()) {
                            $datos[] = [
                                'headerProcedure' => $row['headerProcedure'],
                                'procedureRecipeBookStep' => $row['procedureRecipeBookStep'],


                            ];
                        }
                        if ($resultado3) {
                            if ($resultado3->num_rows) {
                                while ($row = $resultado3->fetch_assoc()) {
                                    $datos[] = [
                                        'descriptionRecipe' => $row['descriptionRecipe'],


                                    ];
                                }
                            }
                        }
                    }
                }
            }

            return $datos;
        } else {
            http_response_code(400);
            return $datos;
        }
    }
}
