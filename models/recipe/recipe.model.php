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
                    if(($recipeName  && $descriptionRecipe && $img && $url && $idAuth)){ 
                        $sentQuery = "INSERT INTO recipe (recipeName,descriptionRecipe,performance,img,url,idAuth)
                        VALUES('" . $recipeName . "','" . $performance . "', '" . $descriptionRecipe . "','" . $img . "','" . $url . "','" . $idAuth . "')";
                        return self::globalService($sentQuery, $idAuth, FALSE);
                    }
                    else {
                        return false;
                    }
                   
                }


                public static function updateRecipe($idRecipe, $recipeName,$performance, $descriptionRecipe,$img,$url, $idAuth)
                {
                    if(($idRecipe && $recipeName  && $descriptionRecipe && $img && $url && $idAuth)){ 

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
            
                    $sentQuery = "SELECT re.recipeName, he.headerName,re.img, re.url, re.creationDate, re.updateDate, group_concat(pr.ingredientDatail) as 'ingredientDatail',  group_concat(pr.percentage) as 'percentage',  group_concat(pr.quantityPounds) as 'quantityPounds',  group_concat(pr.quantityOunces) as 'quantityOunces', re.performance
                                FROM ingredientRecipe pr
                                JOIN headerIngredientRecipe he 
                                ON pr.idHeaderIngredientRecipe =he.idHeaderIngredientRecipe 
                                JOIN recipe re  
                                ON re.idRecipe=he.idRecipe
                                WHERE re.idRecipe=$idRecipe
                                group by he.headerName";
            
                    $sentQuery2 = " SELECT  he.headerProcedure, group_concat( pr.procedureRecipeStep) as 'steps'
                                FROM headerProcedureRecipe he
                                JOIN procedureRecipe pr 
                                ON he.idHeaderProcedureRecipe =pr.idHeaderProcedureRecipe
                                JOIN recipe re  
                                ON re.idRecipe=he.idRecipe
                                WHERE re.idRecipe=$idRecipe
                                group by he.headerProcedure";
            
                    $sentQuery3 = "SELECT descriptionRecipe FROM recipe  WHERE idRecipe='{$idRecipe}'";
            
                    $resultado = self::globalService($sentQuery, $result, FALSE);
                    $resultado2 = self::globalService($sentQuery2, $result, FALSE);
                    $resultado3 = self::globalService($sentQuery3, $result, FALSE);
            
                    $datos = [];
            
                    if ($resultado) {
                        if ($resultado->num_rows) {
                            while ($row = $resultado->fetch_assoc()) {
                                $datos[] = [
                                    'recipeName' => $row['recipeName'],
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
                                            'steps' => $row['steps'],
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
            



