<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipeBook/ingredientRecipeBook.model.php";


    $ingredientRecipeBook = new IngredientRecipeBook();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertIngreRecipeBook':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(ingredientRecipeBook::insertIngredientRecipeBook($datos->ingredientDatail, $datos->percentage,$datos->quantityPounds,
                    $datos->quantityOunces,$datos->idHeaderIngredientRecipeBook)) {
                        http_response_code(200);
                        echo "IngredienteRecipeBook registered";

                    }
                    else {
                        http_response_code(400);
                        echo "IngredienteRecipeBook no registered, complete all data";

                    }
                }
                else {
                    http_response_code(405);
                    echo "internal error";

                }
                break;



                case 'updateIngreRecipeBook':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idIngredient=$_GET['idIngredient'];

                        if(ingredientRecipeBook::updateIngredientRecipeBook($idIngredient, $datos->ingredientDatail, $datos->percentage,$datos->quantityPounds,
                        $datos->quantityOunces,$datos->idHeaderIngredientRecipeBook)) {
                            http_response_code(200);
                            echo "updated IngredienteRecipeBook";

                        }
                        else {
                            http_response_code(400);
                            echo "no updated IngredienteRecipeBook, check the changes o the id entered";

                        }
                    }
                    else {
                        http_response_code(405);
                        echo "internal error";

                    }
                    break;


           
                    case 'deleteIngreRecipeBook':
                        $idIngredient=$_GET['idIngredient'];
        
                         if($idIngredient != NULL) {
        
        
                            if(ingredientRecipeBook::deleteIngredientRecipeBook($idIngredient)) {
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
        
                

            case 'getAllIngreRecipeBook':
                if(ingredientRecipeBook::getAllIngredientRecipeBook()) {
                        http_response_code(200);
                        echo json_encode(ingredientRecipeBook::getAllIngredientRecipeBook());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;


                
            case 'byIdIngreRecipeBook':
                if(isset($_GET['idIngredient'])) {
                    $result = json_encode(ingredientRecipeBook::byIdIngredientRecipeBook($_GET['idIngredient']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    echo "No IngredienteRecipeBook was found with this id";
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
