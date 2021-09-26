<?php
require_once "../../utils/jwt.php";


            class procedureRecipe  extends Connection
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
                                'idProcedureRecipe' => $row['idProcedureRecipe'],
                                'procedureRecipeStep' => $row['procedureRecipeStep'],
                                'idHeaderProcedureRecipe' => $row['idHeaderProcedureRecipe'],
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


                public static function insertProcedureRecipe($procedureRecipeStep, $idHeaderProcedureRecipe)
                {
                    if(($procedureRecipeStep && $idHeaderProcedureRecipe )){ 

                    $sentQuery = "INSERT INTO procedureRecipe (procedureRecipeStep,idHeaderProcedureRecipe)
                    VALUES('".$procedureRecipeStep."', '".$idHeaderProcedureRecipe."')";
                    return self::globalService($sentQuery, $idHeaderProcedureRecipe, TRUE); 
                    }
                    else{
                        return FALSE;
                    }
                }


                public static function updateProcedureRecipe($idProcedureRecipe, $procedureRecipeStep, $idHeaderProcedureRecipe)
                {
                    if(($procedureRecipeStep && $idHeaderProcedureRecipe )){ 

                    $query2 = "SELECT idHeaderProcedureRecipe FROM procedureRecipe WHERE idProcedureRecipe='{$idProcedureRecipe}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE procedureRecipe SET
                      procedureRecipeStep='".$procedureRecipeStep."', idHeaderProcedureRecipe='".$idHeaderProcedureRecipe."'
                      WHERE idProcedureRecipe=$idProcedureRecipe";
                      return self::globalService($sentQuery, $idHeaderProcedureRecipe, TRUE);
                    } else {
                      return FALSE;
                    }
                }
                 }
       



                 public static function deleteProcedureRecipe($idProcedureRecipe)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM procedureRecipe pr JOIN headerProcedureRecipe he 
                    ON pr.idHeaderProcedureRecipe =he.idHeaderProcedureRecipe
                    JOIN recipe re 
                    ON re.idRecipe=he.idRecipe
                    WHERE idProcedureRecipe='{$idProcedureRecipe}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM procedureRecipe WHERE idProcedureRecipe='{$idProcedureRecipe}'";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
 
               public static function getAllProcedureRecipe()
                {
                    $sentQuery = "SELECT * FROM procedureRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                
               public static function getYourProcedureRecipe()
               {
                   $sentQuery = "SELECT pr.idProcedureRecipe, pr.procedureRecipeStep, pr.idHeaderProcedureRecipe 
                   FROM procedureRecipe pr JOIN headerProcedureRecipe he 
                   ON pr.idHeaderProcedureRecipe =he.idHeaderProcedureRecipe 
                   JOIN recipe re 
                   ON re.idRecipe=he.idRecipe
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function byIdProcedureRecipe($idProcedureRecipe): array
                {
                    $sentQuery = "SELECT *FROM procedureRecipe WHERE idProcedureRecipe=$idProcedureRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
