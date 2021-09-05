<?php
require_once "../../utils/jwt.php";


            class procedureRecipeBook  extends Connection
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
                                'idProcedureRecipeBook' => $row['idProcedureRecipeBook'],
                                'procedureRecipeBookStep' => $row['procedureRecipeBookStep'],
                                'idHeaderProcedureRecipeBook' => $row['idHeaderProcedureRecipeBook'],
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


                public static function insertProcedureRecipeBook($procedureRecipeBookStep, $idHeaderProcedureRecipeBook)
                {
                    $sentQuery = "INSERT INTO procedureRecipeBook (procedureRecipeBookStep,idHeaderProcedureRecipeBook)
                    VALUES('".$procedureRecipeBookStep."', '".$idHeaderProcedureRecipeBook."')";
                    return self::globalService($sentQuery, $idHeaderProcedureRecipeBook, TRUE); 
                }


                public static function updateProcedureRecipeBook($idProcedureRecipeBook, $procedureRecipeBookStep, $idHeaderProcedureRecipeBook)
                {
                    $query2 = "SELECT idHeaderProcedureRecipeBook FROM procedureRecipeBook WHERE idProcedureRecipeBook='{$idProcedureRecipeBook}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE procedureRecipeBook SET
                      procedureRecipeBookStep='".$procedureRecipeBookStep."', idHeaderProcedureRecipeBook='".$idHeaderProcedureRecipeBook."'
                      WHERE idProcedureRecipeBook=$idProcedureRecipeBook";
                      return self::globalService($sentQuery, $idHeaderProcedureRecipeBook, TRUE);
                    } else {
                      return FALSE;
                    }
                 }
       


                 public static function deleteProcedureRecipeBook($idProcedureRecipeBook)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM procedureRecipeBook pr JOIN headerProcedureRecipeBook he 
                    ON pr.idHeaderProcedureRecipeBook =he.idHeaderProcedureRecipeBook 
                    JOIN recipeBook re 
                    ON re.idRecipeBook=he.idRecipeBook
                    WHERE idProcedureRecipeBook='{$idProcedureRecipeBook}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM procedureRecipeBook WHERE idProcedureRecipeBook='{$idProcedureRecipeBook}'";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
 
               public static function getAllProcedureRecipeBook()
                {
                    $sentQuery = "SELECT * FROM procedureRecipeBook";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

                
               public static function getYourProcedureRecipeBook()
               {
                   $sentQuery = "SELECT pr.idProcedureRecipeBook, pr.procedureRecipeBookStep, pr.idHeaderProcedureRecipeBook 
                   FROM procedureRecipeBook pr JOIN headerProcedureRecipeBook he 
                   ON pr.idHeaderProcedureRecipeBook =he.idHeaderProcedureRecipeBook 
                   JOIN recipeBook re 
                   ON re.idRecipeBook=he.idRecipeBook
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function byIdProcedureRecipeBook($idProcedureRecipeBook): array
                {
                    $sentQuery = "SELECT *FROM procedureRecipeBook WHERE idProcedureRecipeBook=$idProcedureRecipeBook";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
