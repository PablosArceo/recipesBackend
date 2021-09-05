<?php
require_once "../../utils/jwt.php";


            class headerIngreRecipeBook     extends Connection
            {

                public static function exectQuery($sentQuery){
                    $db = new Connection();
                    $resultQuery = $db->query($sentQuery);
                    return $resultQuery;
                }

                  public static function exectQueryOne($sentQuery){
                    $db = new Connection();
                    $resultQuery = $db->query($sentQuery);
                    $result = $resultQuery->fetch_array()[0] ?? "";
                    return $result;
                }

                public static function printData($resultado){
                    $datos = [];
                    if($resultado->num_rows) {
                        while($row = $resultado->fetch_assoc()) {
                            $datos[] = [
                                'idHeaderIngredientRecipeBook' => $row['idHeaderIngredientRecipeBook'],
                                'headerName' => $row['headerName'],
                                'idRecipeBook' => $row['idRecipeBook'],
                            ];
                        }
                          return $datos;
                      }
                          return $datos;
                  }

    
                public static function globalService($sentQuery, $idAuth, $all, $joinQuery=false)
                {
                    $secret_key = 'passAuth';
                    $cabezera = getallheaders();
                    $token = $cabezera["Authorization"];


                    if ($token) {
                        $query2 = AuthNew::Check($token, $secret_key);
                        $idAuthVerify = get_object_vars($query2)["idAuth"];
                        
                        if ($idAuthVerify == $idAuth) {
                            return self::exectQuery($sentQuery);
                        } else if ($joinQuery == TRUE){
                            $sentQuery .=$idAuthVerify;
                             return self::exectQuery($sentQuery);
                           
                        } else if ($all == TRUE){
                            return self::exectQuery($sentQuery);
                        } else if($idAuth == null){
                            return FALSE;
                        } else {
                            echo "You do not have the necessary permissions  ,";
                        }
                    }
                    else{
                        echo "the request does not have a token   ";
                    }

                }


                public static function insertHeaderIngreRecipeBook($headerName, $idRecipeBook)
                {
                    $sentQuery = "INSERT INTO headerIngredientRecipeBook (headerName,idRecipeBook)
                    VALUES('".$headerName."', '".$idRecipeBook."')";
                    return self::globalService($sentQuery, $idRecipeBook, TRUE); 
                }


                public static function updateHeaderIngreRecipeBook($idHeaderIngredientRecipeBook, $headerName, $idRecipeBook)
                {
                    $query2 = "SELECT idRecipeBook FROM headerIngredientRecipeBook WHERE idHeaderIngredientRecipeBook='{$idHeaderIngredientRecipeBook}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE headerIngredientRecipeBook SET
                      headerName='".$headerName."', idRecipeBook='".$idRecipeBook."'
                      WHERE idHeaderIngredientRecipeBook=$idHeaderIngredientRecipeBook";
                      return self::globalService($sentQuery, $idRecipeBook, TRUE);
                    } else {
                      return FALSE;
                    }
                 }
       



                 public static function deleteHeaderIngreRecipeBook($idHeaderIngredientRecipeBook)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM headerIngredientRecipeBook pr JOIN recipeBook he 
                    ON pr.idRecipeBook =he.idRecipeBook
                    JOIN recipeBook re 
                    ON re.idRecipeBook=he.idRecipeBook
                    WHERE idHeaderIngredientRecipeBook='{$idHeaderIngredientRecipeBook}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM headerIngredientRecipeBook WHERE idHeaderIngredientRecipeBook=$idHeaderIngredientRecipeBook";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
 
               public static function getAllHeaderIngreRecipeBook()
                {
                    $sentQuery ="SELECT *FROM headerIngredientRecipeBook";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                
               public static function getYourIngreRecipeBook()
               {
                   $sentQuery = "SELECT pr.idHeaderIngredientRecipeBook, pr.headerName, pr.idRecipeBook
                   FROM headerIngredientRecipeBook pr JOIN recipeBook he 
                   ON pr.idRecipeBook =he.idRecipeBook
                   JOIN recipeBook re 
                   ON re.idRecipeBook=he.idRecipeBook
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function byIdHeaderIngreRecipeBook($idHeaderIngredientRecipeBook): array
                {
                    $sentQuery = "SELECT *FROM headerIngredientRecipeBook WHERE idHeaderIngredientRecipeBook=$idHeaderIngredientRecipeBook";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
