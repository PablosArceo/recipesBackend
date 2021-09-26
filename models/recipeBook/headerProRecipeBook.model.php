<?php
require_once "../../utils/jwt.php";


            class headerProRecipeBook    extends Connection
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
                                'idHeaderProcedureRecipeBook' => $row['idHeaderProcedureRecipeBook'],
                                'headerProcedure' => $row['headerProcedure'],
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

                public static function insertHeaderProRecipeBook($headerProcedure, $idRecipeBook)
                {
                    if(($headerProcedure && $idRecipeBook )){ 

                    $sentQuery = "INSERT INTO headerProcedureRecipeBook (headerProcedure,idRecipeBook)
                    VALUES('".$headerProcedure."', '".$idRecipeBook."')";
                    return self::globalService($sentQuery, $idRecipeBook, TRUE); 
                }
                else{
                return FALSE;
                }
                }

                public static function updateHeaderProRecipeBook($idHeaderProcedureRecipeBook, $headerProcedure, $idRecipeBook)
                {
                    if(($headerProcedure && $idRecipeBook )){ 

                    $query2 = "SELECT idRecipeBook FROM headerProcedureRecipeBook WHERE idHeaderProcedureRecipeBook='{$idHeaderProcedureRecipeBook}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE headerProcedureRecipeBook SET
                      headerProcedure='".$headerProcedure."', idRecipeBook='".$idRecipeBook."'
                      WHERE idHeaderProcedureRecipeBook=$idHeaderProcedureRecipeBook";
                      return self::globalService($sentQuery, $idRecipeBook, TRUE);
                    } else {
                      return FALSE;
                    }
                }
                 }
       
                 public static function deleteHeaderProRecipeBook($idHeaderProcedureRecipeBook)
                 {
                    $query2 = "SELECT re.idAuth
                    FROM headerProcedureRecipeBook pr JOIN recipeBook he 
                    ON pr.idRecipeBook =he.idRecipeBook
                    JOIN recipeBook re 
                    ON re.idRecipeBook=he.idRecipeBook
                    WHERE idHeaderProcedureRecipeBook='{$idHeaderProcedureRecipeBook}'";
                     $result = self::exectQueryOne($query2);
                     $sentQuery = "DELETE FROM headerProcedureRecipeBook WHERE idHeaderProcedureRecipeBook=$idHeaderProcedureRecipeBook";
                     return self::globalService($sentQuery, $result, FALSE);
                 }
 
 
               public static function getAllHeaderProRecipeBook()
                {
                    $sentQuery ="SELECT *FROM headerProcedureRecipeBook";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }

        
               public static function getYourHProRecipeBook()
               {
                   $sentQuery = "SELECT pr.idHeaderProcedureRecipeBook, pr.headerProcedure, pr.idRecipeBook
                   FROM headerProcedureRecipeBook pr JOIN recipeBook he 
                   ON pr.idRecipeBook =he.idRecipeBook
                   JOIN recipeBook re 
                   ON re.idRecipeBook=he.idRecipeBook
                   WHERE re.idAuth=";
                   $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                   return self::printData($resultado);
               }

                public static function getbyIdHeaderProRecipeBook($idHeaderProcedureRecipeBook): array
                {
                    $sentQuery = "SELECT *FROM headerProcedureRecipeBook WHERE idHeaderProcedureRecipeBook=$idHeaderProcedureRecipeBook";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
            }
