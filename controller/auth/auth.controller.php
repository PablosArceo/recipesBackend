<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/auth/auth.model.php";




    $auth = new Auth();
    $body = json_encode(file_get_contents("php://input"),true);




    switch($_GET['op']){


        case 'insertar':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {
                    if(auth::insert($datos->webSiteName, $datos->password_)) {
                        http_response_code(200);
                        echo "Auth registered";

                    }
                    else {
                        http_response_code(400);
                        echo "Auth no registered";

                    }
                }
                else {
                    http_response_code(405);
                    echo "internal error";

                }
                break;


          
        case 'login':
            $datos = json_decode(file_get_contents('php://input'));

            if($datos != NULL) {
                     $responseToken=auth::login($datos->webSiteName, $datos->password_);
                    if($responseToken) {
                        http_response_code(200);
                        echo $responseToken;

                    }
                    else {
                        http_response_code(400);
                        echo "Please check your webSiteName o password!";

                    }
                }
                else {
                    http_response_code(405);
                    echo "internal error";

                }
                break;
            default:
            break;
    

            

    }
