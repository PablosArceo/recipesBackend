<?php
header('Content-Type: application/');

require_once "../../connection/connection.php";
require_once "../../models/recipe/procedureRecipe.model.php";


$procedureRecipe = new procedureRecipe();
$body = json_encode(file_get_contents("php://input"), true);

switch ($_GET['op']) {



    case 'insertProcedureRecipe':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {


            if (procedureRecipe::insertProcedureRecipe($datos->procedureRecipeStep, $datos->idHeaderProcedureRecipe)) {
                http_response_code(200);
                echo "ProcedureRecipe registered";
            } else {
                http_response_code(400);
                echo "ProcedureRecipe no registered, complete all data correctly";
            }
        } else {
            http_response_code(405);
            echo "internal error";
        }
        break;


    case 'updateProcedureRecipe':
        $datos = json_decode(file_get_contents('php://input'));
        if ($datos != NULL) {
            $idProcedureRecipe = $_GET['idProcedureRecipe'];

            if (procedureRecipe::updateProcedureRecipe(
                $idProcedureRecipe,
                $datos->procedureRecipeStep,
                $datos->idHeaderProcedureRecipe
            )) {
                http_response_code(200);
                echo "updated ProcedureRecipe";
            } else {
                http_response_code(400);
                echo "no updated ProcedureRecipe, check the changes o the id entered";
            }
        } else {
            http_response_code(405);
            echo "internal error";
        }
        break;


    case 'deleteProcedureRecipe':
        $idProcedureRecipe = $_GET['idProcedureRecipe'];

        if ($idProcedureRecipe != NULL) {


            if (procedureRecipe::deleteProcedureRecipe($idProcedureRecipe)) {
                http_response_code(200);
                echo "deleted ProcedureRecipe";
            } else {
                http_response_code(400);
                echo "no deleted ProcedureRecipe, check idProcedureRecip";
            }
        } else {
            http_response_code(405);
            echo "internal error ";
        }
        break;


    case 'getAllProcedureRecipe':
        if (procedureRecipe::getAllProcedureRecipe()) {
            http_response_code(200);
            echo json_encode(procedureRecipe::getAllProcedureRecipe());
        } else {
            http_response_code(400);
            echo "no data";
        }
        break;

        case 'getYourProcedureRecipe':
            if(procedureRecipe::getYourProcedureRecipe()) {
                    http_response_code(200);
                    echo json_encode(procedureRecipe::getYourProcedureRecipe());
                            }
            else {
                    http_response_code(400);
                    echo "no data";
                    }
        break;


    case 'byIdProcedureRecipe':
        if (isset($_GET['idProcedureRecipe'])) {
            $result = json_encode(procedureRecipe::byIdProcedureRecipe($_GET['idProcedureRecipe']));
            $comprobacion = $result == "[]";
            if ($comprobacion == 1) {
                echo "No ProcedureRecipe  was found with this id";
            } else {
                echo $result;
            }
        } else {
            http_response_code(400);
            echo "error interno";
        }
        break;
}
