<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipe/headerIngreRecipe.model.php";


    $headerIngreRecipe = new headerIngredientRecipe();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){

        


        case 'insertHIngreRecipe':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(headerIngredientRecipe::insertHeaderIngreRecipe($datos->headerName, $datos->idRecipe)) {
                        http_response_code(200);
                        echo "headerIngredientRecipe registered";

                    }
                    else {
                        http_response_code(400);
                        echo json_encode("headerIngredientRecipe no registered, fill in all the fields o check the id entered");

                    }
                }
                else {
                    http_response_code(405);
                    echo  json_encode("internal error");

                }
                break;


            case 'updateHeaderIngreRecipe':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idHeaderIngredientRecipe=$_GET['idHeaderIngredientRecipe'];

                        if(headerIngredientRecipe::updateHeaderIngreRecipe($idHeaderIngredientRecipe, $datos->headerName, 
                        $datos->idRecipe)) {
                            http_response_code(200);
                            echo "updated headerIngredientRecipe";
                            echo json_encode(headerIngredientRecipe::byIdHeaderIngreRecipe($_GET['idHeaderIngredientRecipe']));

                        }
                        else {
                            http_response_code(400);
                            echo "no updated headerIngreRecipe, fill in all the fields o check the id entered";
                            echo json_encode(headerIngredientRecipe::byIdHeaderIngreRecipe($_GET['idHeaderIngredientRecipe']));

                        }
                    }
                    else {
                        http_response_code(405);
                        echo json_encode("interal error");

                    }
                    break;


            case 'deleteHeaderIngreRecipe':
                $idHeaderIngredientRecipe=$_GET['idHeaderIngredientRecipe'];

                 if($idHeaderIngredientRecipe != NULL) {


                    if(headerIngredientRecipe::deleteHeaderIngreRecipe($idHeaderIngredientRecipe)) {
                      http_response_code(200);
                      echo "deleted HeaderIngreRecipe";


                  }
                else {
                      http_response_code(400);
                      echo "no deleted headerIngreRecipe, check idHeaderIngredientRecipe";
                      echo json_encode(headerIngredientRecipe::byIdHeaderIngreRecipe($_GET['idHeaderIngredientRecipe']));

                  }
              }
              else {
                  http_response_code(405);
                  echo json_encode("internal error");
              }
              break;


            case 'getAllHeaderIngreRecipe':
                if(headerIngredientRecipe::getAllHeaderIngreRecipe()) {
                        http_response_code(200);
                        echo json_encode(headerIngredientRecipe::getAllHeaderIngreRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;
            
            case 'getYourIngreRecipe':
                if(headerIngredientRecipe::getYourIngreRecipe()) {
                        http_response_code(200);
                        echo json_encode(headerIngredientRecipe::getYourIngreRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;
            
            case 'byIdHeaderIngreRecipe':
                if(isset($_GET['idHeaderIngredientRecipe'])) {
                    $result = json_encode(headerIngredientRecipe::byIdHeaderIngreRecipe($_GET['idHeaderIngredientRecipe']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    http_response_code(400);
                    echo "No headerIngredient  was found with this id";
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
