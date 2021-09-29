<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipe/headerProRecipe.model.php";


    $headerProRecipe = new HeaderProRecipe();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertHeaderProRecipe':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(headerProRecipe::insertHeaderProRecipe($datos->headerProcedure, $datos->idRecipe)) {
                        http_response_code(200);
                        echo "headerProcedureRecipe registered";

                    }
                    else {
                        http_response_code(400);
                        echo json_encode("headerProcedureRecipe no registered, fill in all the fields o check the id entered");

                    }
                }
                else {
                    http_response_code(405);
                    echo json_decode("internal error");

                }
                break;


            case 'updateHeaderProRecipe':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idHeaderProcedureRecipe=$_GET['idHeaderProcedureRecipe'];

                        if(headerProRecipe::updateHeaderProRecipe($idHeaderProcedureRecipe, $datos->headerProcedure, 
                        $datos->idRecipe)) {
                            http_response_code(200);
                            echo "updated headerProcedureRecipe";
                            echo json_encode(headerProRecipe::byIdHeaderProRecipe($_GET['idHeaderProcedureRecipe']));


                        }
                        else {
                            http_response_code(400);
                            echo "no updated headerProcedureRecipe, fill in all the fields o check the id entered";
                            echo json_encode(headerProRecipe::byIdHeaderProRecipe($_GET['idHeaderProcedureRecipe']));
                        }
                    }
                    else {
                        http_response_code(405);
                        echo json_decode("interal error");

                    }
                    break;

           
            case 'deleteHeaderProRecipe':
                $idHeaderProcedureRecipe=$_GET['idHeaderProcedureRecipe'];

                 if($idHeaderProcedureRecipe != NULL) {


                    if(headerProRecipe::deleteHeaderProRecipe($idHeaderProcedureRecipe)) {
                      http_response_code(200);
                      echo "deleted headerProcedureRecipe";


                  }
                else {
                      http_response_code(400);
                      echo "no deleted headerProcedureRecipe, check idHeaderProcedureRecipe";
                      echo json_encode(headerProRecipe::byIdHeaderProRecipe($_GET['idHeaderProcedureRecipe']));

                  }
              }
              else {
                  http_response_code(405);
                  echo json_decode("internal error ");
              }
              break;


            case 'getHeaderProRecipe':
                if(headerProRecipe::getAllHeaderProRecipe()) {
                        http_response_code(200);
                        echo json_encode(headerProRecipe::getAllHeaderProRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;
            
            case 'getYourHProRecipe':
                if(headerProRecipe::getYourHProRecipe()) {
                        http_response_code(200);
                        echo json_encode(headerProRecipe::getYourHProRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;
                        
            case 'byIdHeaderProRecipe':
                if(isset($_GET['idHeaderProcedureRecipe'])) {
                    $result = json_encode(headerProRecipe::byIdHeaderProRecipe($_GET['idHeaderProcedureRecipe']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    http_response_code(400);
                    echo "No headerProcedureRecipe  was found with this id";
                    }else{
                        echo $result;
                    }      
                }
                else {
                        http_response_code(400);
                        echo "error interno";
                        }
            break;
            

    }
