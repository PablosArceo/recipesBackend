<?php
require_once '../../vendor/autoload.php';

use \Firebase\JWT\JWT;


class AuthNew
{
    private static $secret_key = 'passAuth';



    public static function createToken($idAuth, $webSiteName, $pasword_)
    {
        $time = time();

        $token = array(
            'iat' => $time,
            'exp' => $time + (60*60),
            
                'idAuth' => $idAuth,
                'webSiteName'=> $webSiteName,
                'pasword_'=> $pasword_,
        );

        return JWT::encode($token, self::$secret_key);
    }


    public static function Check($token, $secret_key)
    {
        try {
            $decoded = JWT::decode($token, $secret_key, array_keys(JWT::$supported_algs));
            return $decoded;

        } catch (Exception $e) {
            echo $e;
            return false;
            }
    }          
}


        