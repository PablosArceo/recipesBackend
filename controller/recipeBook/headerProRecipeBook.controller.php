<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipeBook/headerProRecipeBook.model.php";


    $headerProRecipeBook = new HeaderProRecipeBook();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertHProRecipeBook':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(headerProRecipeBook::insertHeaderProRecipeBook($datos->headerProcedure, $datos->idRecipeBook)) {
                        http_response_code(200);
                        echo "headerProcedureRecipeBook registered";

                    }
                    else {
                        http_response_code(400);
                        echo "headerProcedureRecipeBook no registered, complete all data correctly";

                    }
                }
                else {
                    http_response_code(405);
                    echo "internal error";

                }
                break;


            case 'updateHeaderProRecipeBook':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idHeaderProcedureRecipeBook=$_GET['idHeaderProcedureRecipeBook'];

                        if(headerProRecipeBook::updateHeaderProRecipeBook($idHeaderProcedureRecipeBook, $datos->headerProcedure, 
                        $datos->idRecipeBook)) {
                            http_response_code(200);
                            echo "updated headerProcedureRecipeBook";

                        }
                        else {
                            http_response_code(400);
                            echo "no updated headerProcedureRecipeBook, check the changes o the id entered";

                        }
                    }
                    else {
                        http_response_code(405);
                        echo "interal error";

                    }
                    break;


           
            case 'deleteHeaderProRecipeBook':
                $idHeaderProcedureRecipeBook=$_GET['idHeaderProcedureRecipeBook'];

                 if($idHeaderProcedureRecipeBook != NULL) {


                    if(headerProRecipeBook::deleteHeaderProRecipeBook($idHeaderProcedureRecipeBook)) {
                      http_response_code(200);
                      echo "deleted headerProcedureRecipeBook";


                  }
                else {
                      http_response_code(400);
                      echo "no deleted headerProcedureRecipeBook, check idHeaderProcedureRecipeBook";

                  }
              }
              else {
                  http_response_code(405);
                  echo "internal error ";
              }
              break;


                

            case 'getHeaderProRecipeBook':
                if(headerProRecipeBook::getAllHeaderProRecipeBook()) {
                        http_response_code(200);
                        echo json_encode(headerProRecipeBook::getAllHeaderProRecipeBook());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;

            case 'getYourHProRecipeBook':
                if(headerProRecipeBook::getYourHProRecipeBook()) {
                        http_response_code(200);
                        echo json_encode(headerProRecipeBook::getYourHProRecipeBook());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;
                
            case 'getbyIdHeaderProRecipeBook':
                if(isset($_GET['idHeaderProcedureRecipeBook'])) {
                    $result = json_encode(headerProRecipeBook::getbyIdHeaderProRecipeBook($_GET['idHeaderProcedureRecipeBook']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    echo "No headerProcedureRecipeBook  was found with this id";
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
