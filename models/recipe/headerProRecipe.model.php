<?php
require_once "../../utils/jwt.php";


            class headerProRecipe    extends Connection
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
                                'idHeaderProcedureRecipe' => $row['idHeaderProcedureRecipe'],
                                'headerProcedure' => $row['headerProcedure'],
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


                public static function insertHeaderProRecipe($headerProcedure, $idRecipe)
                {
                    $sentQuery = "INSERT INTO headerProcedureRecipe (headerProcedure,idRecipe)
                    VALUES('".$headerProcedure."', '".$idRecipe."')";
                    return self::globalService($sentQuery, $idRecipe, TRUE); 
                }


                public static function updateHeaderProRecipe($idHeaderProcedureRecipe, $headerProcedure, $idRecipe)
                {
                    $query2 = "SELECT idRecipe FROM headerProcedureRecipe WHERE idHeaderProcedureRecipe='{$idHeaderProcedureRecipe}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE headerProcedureRecipe SET
                      headerProcedure='".$headerProcedure."', idRecipe='".$idRecipe."'
                      WHERE idHeaderProcedureRecipe=$idHeaderProcedureRecipe";
                      return self::globalService($sentQuery, $idRecipe, TRUE);
                    } else {
                      return FALSE;
                    }
                 }
       



                 public static function deleteHeaderProRecipe($idHeaderProcedureRecipe)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM headerProcedureRecipe pr JOIN recipe he 
                    ON pr.idRecipe =he.idRecipe
                    JOIN recipe re 
                    ON re.idRecipe=he.idRecipe
                    WHERE idHeaderProcedureRecipe='{$idHeaderProcedureRecipe}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM headerProcedureRecipe WHERE idHeaderProcedureRecipe=$idHeaderProcedureRecipe";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
 
               public static function getAllHeaderProRecipe()
                {
                    $sentQuery ="SELECT *FROM headerProcedureRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                
               public static function getYourHProRecipe()
               {
                   $sentQuery = "SELECT pr.idHeaderProcedureRecipe, pr.headerProcedure, pr.idRecipe
                   FROM headerProcedureRecipe pr JOIN recipe he 
                   ON pr.idRecipe =he.idRecipe
                   JOIN recipe re 
                   ON re.idRecipe=he.idRecipe
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function byIdHeaderProRecipe($idHeaderProcedureRecipe): array
                {
                    $sentQuery = "SELECT *FROM headerProcedureRecipe WHERE idHeaderProcedureRecipe=$idHeaderProcedureRecipe";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
