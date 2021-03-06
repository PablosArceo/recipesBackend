<?php
declare(strict_types=1);

require_once '../../vendor/autoload.php';

use \Firebase\JWT\JWT;


class AuthNew
{
    private static $secret_key = 'passAuth';


    public static function createToken($idAuth, $webSiteName)
    {
        $time = time();

        $token = array(
            'iat' => $time,
            'exp' => $time + ( 604800.02* 604800.02),
            
            'idAuth' => $idAuth,
            'webSiteName'=> $webSiteName,
        );


        $arrayToken = array('token' => JWT::encode($token, self::$secret_key));
        return json_encode($arrayToken);


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


        