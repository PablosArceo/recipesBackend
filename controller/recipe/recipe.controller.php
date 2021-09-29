<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipe/recipe.model.php";

    $recipe = new Recipe();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertRecipe':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {
                
                    
                    if(Recipe::insertRecipe($datos->recipeName,$datos->performance,
                    $datos->descriptionRecipe,$datos->img,$datos->url, $datos->idAuth)) {
                        http_response_code(200);
                        echo "Recipe Registered";

                    }
                    else {
                        echo json_encode("recipe no registered, fill in all the fields o check the id entered");
                        http_response_code(400);

                    }
                }
                else {
                    echo json_encode("internal error");
                    http_response_code(405);


                }
                break;


            case 'updateRecipe':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idRecipe=$_GET['idRecipe'];

                        if(Recipe::updateRecipe($idRecipe, $datos->recipeName,$datos->performance, $datos->descriptionRecipe,$datos->img,$datos->url, $datos->idAuth)) {
                            http_response_code(200);
                            echo "Recipe Updated";
                            echo json_encode(recipe::byIdRecipe($_GET['idRecipe']));

                        }
                        else {
                            echo json_encode("no updated recipe, fill in all the fields o check the id entered");
                            http_response_code(400);

                        }
                    }
                    else {
                        http_response_code(405);
                        echo "interal error";

                    }
                    break;


            case 'deleteRecipe':
                 $idRecipe=$_GET['idRecipe'];

                 if($idRecipe != NULL) {


                    if(Recipe::deleteRecipe($idRecipe)) {
                      http_response_code(200);
                      echo json_encode("Recipe deleted");


                  }
                else {
                    http_response_code(400);
                    echo "no deleted recipeBook, check idRecipeBook o the id entered";
                    echo json_encode(Recipe::byIdRecipe($_GET['idRecipe']));

                  }
              }
              else {
                http_response_code(405);
                echo json_encode("internal error");
              }
              break;


            case 'getAllRecipe':
                if(Recipe::getAllRecipe()) {
                        http_response_code(200);
                        echo json_encode(Recipe::getAllRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;


            case 'getYourRecipe':
                if(Recipe::getYourRecipe()) {
                        http_response_code(200);
                        echo json_encode(Recipe::getYourRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;

                
            case 'byIdRecipe':
                if(isset($_GET['idRecipe'])) {
                    $result = json_encode(Recipe::byIdRecipe($_GET['idRecipe']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    http_response_code(400);
                    echo "No recipe  was found with this id";
                    }else{
                        echo $result;
                    }      
                }
                else {
                        http_response_code(400);
                        echo "error interno";
                        }
            break;

          

            case 'getCompleteRecipe':
                if(isset($_GET['idRecipe'])) {
                    $result = json_encode(recipe::getCompleteRecipe($_GET['idRecipe']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                        http_response_code(400);

                        echo "No recipe  was found with this id";
                    }
                    else{
                        echo $result;

                    }                         
                }
                else {
                        http_response_code(400);
                        echo "error interno";
                        }
            break;
            
            

    }
