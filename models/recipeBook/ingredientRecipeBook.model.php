<?php
require_once "../../utils/jwt.php";


            class ingredientRecipeBook   extends Connection
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
                                'idHeaderIngredientRecipeBook' => $row['idHeaderIngredientRecipeBook'],
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


                public static function insertIngredientRecipeBook($ingredientDatail,$percentage,$quantityPounds,$quantityOunces,$idHeaderIngredientRecipeBook)
                {
                    $sentQuery = "INSERT INTO ingredientRecipeBook (ingredientDatail,percentage,quantityPounds,quantityOunces,idHeaderIngredientRecipeBook)
                    VALUES('".$ingredientDatail."','".$percentage."','".$quantityPounds."','".$quantityOunces."',$idHeaderIngredientRecipeBook)";
                    return self::globalService($sentQuery, $idHeaderIngredientRecipeBook, TRUE); 
                }


                public static function updateIngredientRecipeBook($idIngredient, $ingredientDatail, $percentage, $quantityPounds,$quantityOunces,
                $idHeaderIngredientRecipeBook)
                {
                    $query2 = "SELECT idHeaderIngredientRecipeBook FROM ingredientRecipeBook WHERE idIngredient='{$idIngredient}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE ingredientRecipeBook SET
                      ingredientDatail='".$ingredientDatail."', percentage='".$percentage."', quantityPounds='".$quantityPounds."',quantityOunces='".$quantityOunces."',
                      idHeaderIngredientRecipeBook='".$idHeaderIngredientRecipeBook."'
                      WHERE idIngredient=$idIngredient";
                      return self::globalService($sentQuery, $idHeaderIngredientRecipeBook, TRUE);
                    } else {
                      return FALSE;
                    }
                 }
       



                 public static function deleteIngredientRecipeBook($idIngredient)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM ingredientRecipeBook pr JOIN headerIngredientRecipeBook he 
                    ON pr.idHeaderIngredientRecipeBook =he.idHeaderIngredientRecipeBook
                    JOIN recipeBook re 
                    ON re.idRecipeBook=he.idRecipeBook
                    WHERE idIngredient='{$idIngredient}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM ingredientRecipeBook WHERE idIngredient='{$idIngredient}'";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
 
               public static function getAllIngredientRecipeBook()
                {
                    $sentQuery = "SELECT *FROM ingredientRecipeBook";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                
               public static function getYourIngredientRecipeBook()
               {
                   $sentQuery = "SELECT pr.idIngredient, pr.ingredientDatail, pr.percentage, pr.quantityPounds, pr.quantityOunces, pr.idHeaderIngredientRecipeBook 
                   FROM ingredientRecipeBook pr JOIN headerIngredientRecipeBook he 
                   ON pr.idHeaderIngredientRecipeBook =he.idHeaderIngredientRecipeBook 
                   JOIN recipeBook re 
                   ON re.idRecipeBook=he.idRecipeBook
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function byIdIngredientRecipeBook($idIngredient): array
                {
                    $sentQuery = "SELECT *FROM ingredientRecipeBook WHERE idIngredient=$idIngredient";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
