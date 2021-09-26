<?php
    require_once "../../utils/jwt.php";
    

    class auth extends Connection{


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
                          'idAuth' => $row['idAuth'],
                          'webSiteName' => $row['webSiteName'],
                          'password_' => $row['password_'],
                          'img' => $row['img'],
                          'url' => $row['url'],
                          'country' => $row['country'],
                          'creationDate' => $row['creationDate'],
                          'updateDate' => $row['updateDate'],
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



        public static function insert($webSiteName, $password_,$img, $url, $country, $mark) {
            $password_ = password_hash($password_, PASSWORD_BCRYPT);

            $db = new Connection();
            $query = "INSERT INTO auth (webSiteName,password_,img,url,country,mark) 
            VALUES('".$webSiteName."', '".$password_."',  '".$img."', '".$url."', '".$country."', '".$mark."' )";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }



        public static function login($webSiteName, $password_) {
            $db = new Connection();
            $authN = new AuthNew();


            $query1 ="SELECT password_ FROM AUTH WHERE webSiteName='$webSiteName'";
            $query2 ="SELECT idAuth FROM AUTH WHERE webSiteName='$webSiteName'";

            $resultQuery=$db->query($query1);
            $resultNew=$db->query($query2);
            $result2= $resultNew->fetch_array()[0] ?? "";


            $result= $resultQuery->fetch_array()[0] ?? "";
            if($resultQuery){
                $confirm=password_verify($password_, strval($result));
                if($confirm==1){
                   return authNew::createToken($result2,$webSiteName,$password_);

                }
                

            }
            else{
                http_response_code(405);
                echo "webSiteName or password incorrect ";
            }
        }

        public static function updateAuth($idAuth, $webSiteName, $img,$url,$country, $mark)
                {
                    $query2 = "SELECT idAuth FROM auth WHERE idAuth='{$idAuth}'";
                    $result = self::exectQueryOne($query2);

                    if($result){
                      $sentQuery = "UPDATE auth SET
                      idAuth='".$idAuth."', webSiteName='".$webSiteName."', img='".$img."',url='".$url."',
                      country='".$country."',  mark='".$mark."'
                      WHERE idAuth=$idAuth";
                      return self::globalService($sentQuery, $result, FALSE);
                    } else {
                      return FALSE;
                    }
                 }

        
        public static function deleteAuth($idAuth)
                 {
                     $query2 = "SELECT idAuth FROM auth WHERE idAuth='{$idAuth}'";
                     $result = self::exectQueryOne($query2);
 
                     $sentQuery = "DELETE FROM auth WHERE idAuth='{$idAuth}'";
                     return self::globalService($sentQuery, $result, FALSE);
                 }

        public static function byIdAuth($idAuth): array
                 {
                     $sentQuery = "SELECT *FROM auth WHERE idAuth=$idAuth";
                     $resultado = self::globalService($sentQuery, null, TRUE);
                     return self::printData($resultado);
                 }
        
        public static function getDetailAuth()
                 {
                     $sentQuery = "SELECT * from auth where idAuth=";
                     $resultado = self::globalService($sentQuery, null, TRUE, TRUE);
                     return self::printData($resultado);
                 }
        
        public static function getAllAuth()
                {
                    $sentQuery = "SELECT * FROM auth";
                    $resultado = self::globalService($sentQuery, null, TRUE);
                    return self::printData($resultado);
                }
         
    }
