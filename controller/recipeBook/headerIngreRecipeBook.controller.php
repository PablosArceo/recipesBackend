<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipeBook/headerIngreRecipeBook.model.php";

    error_reporting(0);

    $headerIngreRecipeBook = new headerIngreRecipeBook();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertHIngreRecipeBook':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(headerIngreRecipeBook::insertHeaderIngreRecipeBook($datos->headerName, $datos->idRecipeBook)) {
                        http_response_code(200);
                        echo "headerIngredientRecipeBook registered";

                    }
                    else {
                        http_response_code(400);
                        echo json_encode("headerIngredientRecipeBook no registered, fill in all the fields  o check the id entered");

                    }
                }
                else {
                    http_response_code(405);
                    echo json_encode("internal error");

                }
                break;


            case 'updateHeaderIngreRecipeBook':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idHeaderIngredientRecipeBook=$_GET['idHeaderIngredientRecipeBook'];

                        if(headerIngreRecipeBook::updateHeaderIngreRecipeBook($idHeaderIngredientRecipeBook, $datos->headerName, 
                        $datos->idRecipeBook)) {
                            http_response_code(200);
                            echo "updated headerIngredientRecipeBook";
                            echo json_encode(headerIngreRecipeBook::byIdHeaderIngreRecipeBook($_GET['idHeaderIngredientRecipeBook']));

                        }
                        else {
                            http_response_code(400);
                            echo "no updated headerIngreRecipeBook, fill in all the fields o check the id entered";
                            echo json_encode(headerIngreRecipeBook::byIdHeaderIngreRecipeBook($_GET['idHeaderIngredientRecipeBook']));

                        }
                    }
                    else {
                        http_response_code(405);
                        echo "interal error";

                    }
                    break;


           
            case 'deleteHeaderIngreRecipeBook':
                $idHeaderIngredientRecipeBook=$_GET['idHeaderIngredientRecipeBook'];

                 if($idHeaderIngredientRecipeBook != NULL) {


                    if(headerIngreRecipeBook::deleteHeaderIngreRecipeBook($idHeaderIngredientRecipeBook)) {
                      http_response_code(200);
                      echo "deleted headerIngreRecipeBook";


                  }
                else {
                      http_response_code(400);
                      echo "no deleted headerIngreRecipeBook, check idHeaderIngredientRecipeBook";
                      echo json_encode(headerIngreRecipeBook::byIdHeaderIngreRecipeBook($_GET['idHeaderIngredientRecipeBook']));

                  }
              }
              else {
                  http_response_code(405);
                  echo json_encode("internal error ");
              }
              break;


                

            case 'getAllHeaderIngreRecipeBook':
                if(headerIngreRecipeBook::getAllHeaderIngreRecipeBook()) {
                        http_response_code(200);
                        echo json_encode(headerIngreRecipeBook::getAllHeaderIngreRecipeBook());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;

            case 'getYourIngreRecipeBook':
                if(headerIngreRecipeBook::getYourIngreRecipeBook()) {
                        http_response_code(200);
                        echo json_encode(headerIngreRecipeBook::getYourIngreRecipeBook());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;


                
            case 'byIdHeaderIngreRecipeBook':
                if(isset($_GET['idHeaderIngredientRecipeBook'])) {
                    $result = json_encode(headerIngreRecipeBook::byIdHeaderIngreRecipeBook($_GET['idHeaderIngredientRecipeBook']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    http_response_code(400);
                    echo "No headerIngredientBook  was found with this id";
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
