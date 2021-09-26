<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipe/ingredientRecipe.model.php";


    $ingredientRecipe = new IngredientRecipe();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertIngreRecipe':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(ingredientRecipe::insertIngredientRecipe($datos->ingredientDatail, $datos->percentage,$datos->quantityPounds,
                    $datos->quantityOunces,$datos->idHeaderIngredientRecipe)) {
                        http_response_code(200);
                        echo "IngredienteRecipe registered";

                    }
                    else {
                        http_response_code(400);
                        echo "IngredienteRecipe no registered, fill in all the fields o check the id entered";

                    }
                }
                else {
                    http_response_code(405);
                    echo "internal error";

                }
                break;


                case 'updateIngreRecipe':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idIngredient=$_GET['idIngredient'];

                        if(ingredientRecipe::updateIngredientRecipe($idIngredient, $datos->ingredientDatail, $datos->percentage,$datos->quantityPounds,
                        $datos->quantityOunces,$datos->idHeaderIngredientRecipe)) {
                            http_response_code(200);
                            echo "updated IngredienteRecipe";

                        }
                        else {
                            http_response_code(400);
                            echo "no updated IngredienteRecipe, fill in all the fields o check the id entered";

                        }
                    }
                    else {
                        http_response_code(405);
                        echo "internal error";

                    }
                    break;

           
                    case 'deleteIngreRecipe':
                        $idIngredient=$_GET['idIngredient'];
        
                         if($idIngredient != NULL) {
        
        
                            if(ingredientRecipe::deleteIngredientRecipe($idIngredient)) {
                              http_response_code(200);
                              echo "deleted Ingredient";
        
        
                          }
                        else {
                              http_response_code(400);
                              echo "no deleted Ingredient, check idIngredient";
        
                          }
                      }
                      else {
                          http_response_code(405);
                          echo "internal error ";
                      }
                      break;
        
            case 'getAllIngreRecipe':
                if(ingredientRecipe::getAllIngredientRecipe()) {
                        http_response_code(200);
                        echo json_encode(ingredientRecipe::getAllIngredientRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;

            case 'getYourIngredientRecipe':
                if(ingredientRecipe::getYourIngredientRecipe()) {
                        http_response_code(200);
                        echo json_encode(ingredientRecipe::getYourIngredientRecipe());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;

            case 'byIdIngreRecipe':
                if(isset($_GET['idIngredient'])) {
                    $result = json_encode(ingredientRecipe::byIdIngredientRecipe($_GET['idIngredient']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    http_response_code(400);
                    echo "No IngredienteRecipe was found with this id";
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
