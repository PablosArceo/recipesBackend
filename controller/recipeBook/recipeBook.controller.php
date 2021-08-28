<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipeBook/recipeBook.model.php";


    $recipeBook = new RecipeBook();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertRecipeBook':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(recipeBook::insertRecipeBook($datos->recipeBookName, $datos->performance,$datos->descriptionRecipe, $datos->idAuth)) {
                        http_response_code(200);
                        echo "recipeBook registered";

                    }
                    else {
                        http_response_code(400);
                        echo "recipeBook no registered, complete all data";

                    }
                }
                else {
                    http_response_code(405);
                    echo "internal error";

                }
                break;


            case 'updateRecipeBook':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idRecipeBook=$_GET['idRecipeBook'];

                        if(recipeBook::updateRecipeBook($idRecipeBook, $datos->recipeBookName, $datos->performance, $datos->descriptionRecipe, $datos->idAuth)) {
                            http_response_code(200);
                            echo "updated recipeBook";

                        }
                        else {
                            http_response_code(400);
                            echo "no updated recipeBook, check the changes o the id entered";

                        }
                    }
                    else {
                        http_response_code(405);
                        echo "interal error";

                    }
                    break;


           
            case 'deleteRecipeBook':
                 $idRecipeBook=$_GET['idRecipeBook'];

                 if($idRecipeBook != NULL) {


                    if(recipeBook::deleteRecipeBook($idRecipeBook)) {
                      http_response_code(200);
                      echo "deleted recipeBook";


                  }
                else {
                      http_response_code(400);
                      echo "no deleted recipeBook, check idRecipeBook o the id entered";

                  }
              }
              else {
                  http_response_code(405);
                  echo "internal error AA";
              }
              break;


                

            case 'getRecipeBook':
                if(recipeBook::getAllRecipeBook()) {
                        http_response_code(200);
                        echo json_encode(recipeBook::getAllRecipeBook());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;


                
            case 'getbyIdRecipeBook':
                if(isset($_GET['idRecipeBook'])) {
                    $result = json_encode(recipeBook::byIdRecipeBook($_GET['idRecipeBook']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    echo "No recipe book was found with this id";
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