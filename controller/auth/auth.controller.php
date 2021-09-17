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
                    if(auth::insert($datos->webSiteName, $datos->password_,$datos->img,$datos->url,$datos->country,$datos->mark )) {
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

            case 'updateAuth':
                $datos = json_decode(file_get_contents('php://input'));
                if($datos != NULL) {
                    $idAuth=$_GET['idAuth'];

                    if(auth::updateAuth($idAuth, $datos->webSiteName, $datos->img, $datos->url, $datos->country, $datos->mark)) {
                        http_response_code(200);
                        echo "updated auth";

                    }
                    else {
                        http_response_code(400);
                        echo "no updated auth, check the changes o the id entered";

                    }
                }
                else {
                    http_response_code(405);
                    echo "interal error";

                }
                break;

                case 'deleteAuth':
                    $idAuth=$_GET['idAuth'];
   
                    if($idAuth != NULL) {
   
   
                       if(auth::deleteAuth($idAuth)) {
                         http_response_code(200);
                         echo "deleted auth";
   
   
                     }
                   else {
                         http_response_code(400);
                         echo "no deleted auth, check idRecipeBook o the id entered";
   
                     }
                 }
                 else {
                     http_response_code(405);
                     echo "internal error ";
                 }
                 break;


                     
            case 'byIdAuth':
                if(isset($_GET['idAuth'])) {
                    $result = json_encode(auth::byIdAuth($_GET['idAuth']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    echo "No auth was found with this id";
                    }else{
                        echo $result;
                    }      
                }
                else {
                        http_response_code(400);
                        echo "error interno";
                        }
            break;


            
            case 'getDetailAuth':
                if(auth::getDetailAuth()) {
                        http_response_code(200);
                        echo json_encode(auth::getDetailAuth());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;


            case 'getAllAuth':
                if(auth::getAllAuth()) {
                        http_response_code(200);
                        echo json_encode(auth::getAllAuth());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;


            
          
    }
