<?php
    require_once "../../utils/jwt.php";

    class auth extends Connection{


        



        public static function insert($webSiteName, $password_) {
            $password_ = password_hash($password_, PASSWORD_BCRYPT);

            $db = new Connection();
            $query = "INSERT INTO auth (webSiteName, password_)
            VALUES('".$webSiteName."', '".$password_."')";
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
                echo "webSiteName es incorrecto ";
            }
        } 


        
    }
