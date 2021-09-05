<?php
require_once "../../utils/jwt.php";


            class headerIngredientRecipe      extends Connection
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
                                'idHeaderIngredientRecipe' => $row['idHeaderIngredientRecipe'],
                                'headerName' => $row['headerName'],
                                'idRecipe' => $row['idRecipe'],
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


                public static function insertHeaderIngreRecipe($headerName, $idRecipe)
                {
                    $sentQuery = "INSERT INTO headerIngredientRecipe (headerName,idRecipe)
                    VALUES('".$headerName."', '".$idRecipe."')";
                    return self::globalService($sentQuery, $idRecipe, TRUE); 
                }


                public static function updateHeaderIngreRecipe($idHeaderIngredientRecipe, $headerName, $idRecipe)
                {
                    $query2 = "SELECT idRecipe FROM headerIngredientRecipe WHERE idHeaderIngredientRecipe='{$idHeaderIngredientRecipe}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE headerIngredientRecipe SET
                      headerName='".$headerName."', idRecipe='".$idRecipe."'
                      WHERE idHeaderIngredientRecipe=$idHeaderIngredientRecipe";
                      return self::globalService($sentQuery, $idRecipe, TRUE);
                    } else {
                      return FALSE;
                    }
                 }
       



                 public static function deleteHeaderIngreRecipe($idHeaderIngredientRecipe)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM headerIngredientRecipe pr JOIN recipe he 
                    ON pr.idRecipe =he.idRecipe
                    JOIN recipe re 
                    ON re.idRecipe=he.idRecipe
                    WHERE idHeaderIngredientRecipe='{$idHeaderIngredientRecipe}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM headerIngredientRecipe WHERE idHeaderIngredientRecipe=$idHeaderIngredientRecipe";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
 
               public static function getAllHeaderIngreRecipe()
                {
                    $sentQuery ="SELECT *FROM headerIngredientRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                
               public static function getYourIngreRecipe()
               {
                   $sentQuery = "SELECT pr.idHeaderIngredientRecipe, pr.headerName, pr.idRecipe
                   FROM headerIngredientRecipe pr JOIN recipe he 
                   ON pr.idRecipe =he.idRecipe
                   JOIN recipe re 
                   ON re.idRecipe=he.idRecipe
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function byIdHeaderIngreRecipe($idHeaderIngredientRecipe): array
                {
                    $sentQuery = "SELECT *FROM headerIngredientRecipe WHERE idHeaderIngredientRecipe=$idHeaderIngredientRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
