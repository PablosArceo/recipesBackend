<?php
require_once "../../utils/jwt.php";


            class recipe extends Connection
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
                    if ($resultado->num_rows) {
                          while ($row = $resultado->fetch_assoc()) {
                              $datos[] = [
                                  'idRecipe' => $row['idRecipe'],
                                  'recipeName' => $row['recipeName'],
                                  'descriptionRecipe' => $row['descriptionRecipe'],
                                  'performance' => $row['performance'],
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


                public static function insertRecipe($recipeName,$performance, $descriptionRecipe,$img,$url, $idAuth)
                {
                    $sentQuery = "INSERT INTO recipe (recipeName,descriptionRecipe,performance,img,url,idAuth)
                    VALUES('" . $recipeName . "','" . $performance . "', '" . $descriptionRecipe . "','" . $img . "','" . $url . "','" . $idAuth . "')";
                    return self::globalService($sentQuery, $idAuth, FALSE);
                }


                public static function updateRecipe($idRecipe, $recipeName,$performance, $descriptionRecipe,$img,$url, $idAuth)
                {
                    $query2 = "SELECT idAuth FROM recipe WHERE idRecipe='{$idRecipe}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE recipe SET
                      recipeName='" . $recipeName . "',  performance='" . $performance .  "', descriptionRecipe='" . $descriptionRecipe .   "', img='" . $img .  "',url='" . $url .  "', idAuth='" . $idAuth . "' 
                      WHERE idRecipe=$idRecipe";
                      return self::globalService($sentQuery, $idAuth, FALSE);
                    } else {
                      return FALSE;
                    }
                 }

                public static function deleteRecipe($idRecipe)
                {
                    $query2 = "SELECT idAuth FROM recipe WHERE idRecipe='{$idRecipe}'";
                    $result = self::exectQueryOne($query2);

                    $sentQuery = "DELETE FROM recipe WHERE idRecipe='{$idRecipe}'";
                    return self::globalService($sentQuery, $result, FALSE);
                }


               public static function getAllRecipe()
                {
                    $sentQuery = "SELECT * FROM recipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }


                public static function getYourRecipe()
                {
                    $sentQuery = "SELECT * from recipe where idAuth=";
                    $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                    return self::printData($resultado);
                }

                public static function byIdRecipe($idRecipe): array
                {
                    $sentQuery = "SELECT *FROM recipe WHERE idRecipe=$idRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                

                public static function getCompleteRecipe($idRecipe)
                {
                    $query2 = "SELECT idAuth FROM recipe WHERE idRecipe='{$idRecipe}'";
                    $result = self::exectQueryOne($query2);

                    $sentQuery = "SELECT  re.recipeName, re.url, re.img, re.creationDate, re.updateDate, he.headerName, ir.ingredientDatail, ir.percentage, ir.quantityPounds, ir.quantityOunces, 
                    re.performance, re.descriptionRecipe, pro.headerProcedure, proRe.procedureRecipeStep

                    FROM ingredientRecipe ir
                    JOIN headerIngredientRecipe he 
                    ON ir.idHeaderIngredientRecipe =he.idHeaderIngredientRecipe 
                    JOIN recipe re  
                    ON re.idRecipe=he.idRecipe
                    JOIN headerProcedureRecipe pro
                    JOIN  procedureRecipe proRe
                    on pro.idHeaderProcedureRecipe=proRe.idHeaderProcedureRecipe
                    WHERE  re.idRecipe='{$idRecipe}'";
                    $resultado = self::globalService($sentQuery, $result, FALSE);
                    $datos = [];

                    if($resultado){
                        if ($resultado->num_rows) {
                            while ($row = $resultado->fetch_assoc()) {
                                $datos[] = [
                                    'recipeName' => $row['recipeName'],
                                    'url' => $row['url'],
                                    'img' => $row['img'],
                                    'creationDate' => $row['creationDate'],
                                    'updateDate' => $row['updateDate'],
                                    'headerName' => $row['headerName'],
                                    'ingredientDatail' => $row['ingredientDatail'],
                                    'percentage' => $row['percentage'],
                                    'quantityPounds' => $row['quantityPounds'],
                                    'quantityOunces' => $row['quantityOunces'],
                                    'performance' => $row['performance'],
                                    'descriptionRecipe' => $row['descriptionRecipe'],
                                    'headerProcedure' => $row['headerProcedure'],
                                    'procedureRecipeStep' => $row['procedureRecipeStep'],
    
                                ];
                            }
                            return $datos;
                        }

                    }else{
                        http_response_code(400);
                        return $datos;

                    }

                 
                } 

               

            }
            



