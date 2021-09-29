<?php
header('Content-Type: application/');

require_once "../../connection/connection.php";
require_once "../../models/recipeBook/recipeBook.model.php";

error_reporting(0);

$recipeBook = new RecipeBook();
$body = json_encode(file_get_contents("php://input"), true);

switch ($_GET['op']) {



    case 'insertRecipeBook':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {


            $createRecipeBook = recipeBook::insertRecipeBook($datos->recipeBookName, $datos->performance, $datos->descriptionRecipe, $datos->img, $datos->url, $datos->idAuth);
            if ($createRecipeBook) {
                http_response_code(200);
                echo "Recipe Registered";
            } else {
                echo json_encode("recipeBook no registered, fill in all the fields o check the id entered");
                http_response_code(400);
            }
        } else {
            echo json_encode("internal error");
            http_response_code(405);
        }
        break;


    case 'updateRecipeBook':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            $idRecipeBook = $_GET['idRecipeBook'];

            
          
                if (recipeBook::updateRecipeBook($idRecipeBook, $datos->recipeBookName, $datos->performance, $datos->descriptionRecipe, $datos->img, $datos->url, $datos->idAuth)) {
                    http_response_code(200);
                    echo "Recipe Updated";
                    echo json_encode(recipeBook::byIdRecipeBook($_GET['idRecipeBook']));
                
                
               
            } else {
                echo "no updated recipeBook, fill in all the fields o check the id entered";
                

                echo json_encode(recipeBook::byIdRecipeBook($_GET['idRecipeBook']));
                http_response_code(400);
            }
            
        }else {
            echo json_encode("Error interno");
            http_response_code(405);
        }
        break;





    case 'deleteRecipeBook':
        $idRecipeBook = $_GET['idRecipeBook'];

        if ($idRecipeBook != NULL) {


            if (recipeBook::deleteRecipeBook($idRecipeBook)) {
                http_response_code(200);

                echo json_encode("RecipeBook deleted");
            } else {
                http_response_code(400);
                echo json_encode("no deleted recipeBook, check idRecipeBook o the id entered");
            }
        } else {
            http_response_code(405);
            echo json_encode("internal error");
        }
        break;




    case 'getRecipeBook':
        if (recipeBook::getAllRecipeBook()) {
            http_response_code(200);
            echo json_encode(recipeBook::getAllRecipeBook());
        } else {
            http_response_code(400);
            echo "no data";
        }
        break;

      



    case 'getYourRecipeBook':
        if (recipeBook::getYourRecipeBook()) {
            http_response_code(200);
            echo json_encode(recipeBook::getYourRecipeBook());
        } else {
            http_response_code(400);
            echo "no data";
        }
        break;



    case 'getbyIdRecipeBook':
        if (isset($_GET['idRecipeBook'])) {
            $result = json_encode(recipeBook::byIdRecipeBook($_GET['idRecipeBook']));
            $comprobacion = $result == "[]";
            if ($comprobacion == 1) {
                http_response_code(400);
                echo "No recipe book was found with this id";
            } else {
                echo $result;
            }
        } else {
            http_response_code(400);
            echo "error interno";
        }
        break;


    case 'getCompleteRecipeBook':
        if (isset($_GET['idRecipeBook'])) {
            $result = json_encode(recipeBook::getCompleteRecipeBook($_GET['idRecipeBook']));
            $comprobacion = $result == "[]";
            if ($comprobacion == 1) {
                http_response_code(400);

                echo "No recipe book was found with this id";
            } else {
                echo $result;
            }
        } else {
            http_response_code(400);
            echo "error interno";
        }
        break;
}
