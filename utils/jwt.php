<?php
require_once '../../vendor/autoload.php';

use Firebase\JWT\JWT;

class AuthNew
{
    private static $secret_key = 'passAuth';



    public static function createToken($idAuth, $webSiteName, $pasword_)
    {
        $time = time();

        $token = array(
            'iat' => $time,
            'exp' => $time--,
            'data' => [
                'idAuth' => $idAuth,
                'webSiteName'=> $webSiteName,
                'pasword_'=> $pasword_,
               
            ]
        );

        return JWT::encode($token, self::$secret_key);
    }
}
