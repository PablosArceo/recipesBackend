<?php
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

            $query1 ="SELECT password_ FROM AUTH WHERE webSiteName='$webSiteName'";
            $resultQuery=$db->query($query1);
            $result= $resultQuery->fetch_array()[0] ?? "";

            if($resultQuery){
               return password_verify($password_, strval($result));
            }
            else{
                http_response_code(405);
                echo "webSiteName es incorrecto ";
            }
        } 
    }
