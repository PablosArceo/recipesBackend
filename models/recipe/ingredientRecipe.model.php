<?php
require_once "../../utils/jwt.php";


            class ingredientRecipe    extends Connection
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
                                'idIngredient' => $row['idIngredient'],
                                'ingredientDatail' => $row['ingredientDatail'],
                                'percentage' => $row['percentage'],
                                'quantityPounds' => $row['quantityPounds'],
                                'quantityOunces' => $row['quantityOunces'],
                                'idHeaderIngredientRecipe' => $row['idHeaderIngredientRecipe'],
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


                public static function insertIngredientRecipe($ingredientDatail,$percentage,$quantityPounds,$quantityOunces,$idHeaderIngredientRecipe)
                {
                    if(($ingredientDatail && $percentage && $quantityPounds && $quantityOunces && $idHeaderIngredientRecipe )){ 

                    $sentQuery = "INSERT INTO ingredientRecipe (ingredientDatail,percentage,quantityPounds,quantityOunces,idHeaderIngredientRecipe)
                    VALUES('".$ingredientDatail."','".$percentage."','".$quantityPounds."','".$quantityOunces."',$idHeaderIngredientRecipe)";
                    return self::globalService($sentQuery, $idHeaderIngredientRecipe, TRUE); 
                }
                    else{
                    return FALSE;
                }
                }


                public static function updateIngredientRecipe($idIngredient, $ingredientDatail, $percentage, $quantityPounds,$quantityOunces,
                $idHeaderIngredientRecipe)
                {
                    if(($ingredientDatail && $percentage && $quantityPounds && $quantityOunces && $idHeaderIngredientRecipe )){ 

                    $query2 = "SELECT idHeaderIngredientRecipe FROM ingredientRecipe WHERE idIngredient='{$idIngredient}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE ingredientRecipe SET
                      ingredientDatail='".$ingredientDatail."', percentage='".$percentage."', quantityPounds='".$quantityPounds."',quantityOunces='".$quantityOunces."',
                      idHeaderIngredientRecipe='".$idHeaderIngredientRecipe."'
                      WHERE idIngredient=$idIngredient";
                      return self::globalService($sentQuery, $idHeaderIngredientRecipe, TRUE);
                    } else {
                      return FALSE;
                    }
                }
                 }
       



                 public static function deleteIngredientRecipe($idIngredient)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM ingredientRecipe pr JOIN headerIngredientRecipe he 
                    ON pr.idHeaderIngredientRecipe =he.idHeaderIngredientRecipe
                    JOIN recipe re 
                    ON re.idRecipe=he.idRecipe
                    WHERE idIngredient='{$idIngredient}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM ingredientRecipe WHERE idIngredient='{$idIngredient}'";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
 
               public static function getAllIngredientRecipe()
                {
                    $sentQuery = "SELECT *FROM ingredientRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                
               public static function getYourIngredientRecipe()
               {
                   $sentQuery = "SELECT pr.idIngredient, pr.ingredientDatail, pr.percentage, pr.quantityPounds, pr.quantityOunces, pr.idHeaderIngredientRecipe
                   FROM ingredientRecipe pr JOIN headerIngredientRecipe he 
                   ON pr.idHeaderIngredientRecipe =he.idHeaderIngredientRecipe 
                   JOIN recipe re 
                   ON re.idRecipe=he.idRecipe
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function byIdIngredientRecipe($idIngredient): array
                {
                    $sentQuery = "SELECT *FROM ingredientRecipe WHERE idIngredient=$idIngredient";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
