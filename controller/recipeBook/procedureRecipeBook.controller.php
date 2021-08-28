<?php
    header('Content-Type: application/');

    require_once "../../connection/connection.php";
    require_once "../../models/recipeBook/procedureRecipeBook.model.php";


    $procedureRecipeBook = new ProcedureRecipeBook();
    $body = json_encode(file_get_contents("php://input"),true);

    switch($_GET['op']){



        case 'insertHProcedureRecipeBook':
            $datos = json_decode(file_get_contents('php://input'));
            if($datos != NULL) {

                    
                    if(procedureRecipeBook::insertProcedureRecipeBook($datos->procedureRecipeBookStep, $datos->idHeaderProcedureRecipeBook)) {
                        http_response_code(200);
                        echo "ProcedureRecipeBook registered";

                    }
                    else {
                        http_response_code(400);
                        echo "ProcedureRecipeBook no registered, complete all data";

                    }
                }
                else {
                    http_response_code(405);
                    echo "internal error";

                }
                break;



                case 'updateProcedureRecipeBook':
                    $datos = json_decode(file_get_contents('php://input'));
                    if($datos != NULL) {
                        $idProcedureRecipeBook=$_GET['idProcedureRecipeBook'];

                        if(procedureRecipeBook::updateProcedureRecipeBook($idProcedureRecipeBook, $datos->procedureRecipeBookStep, 
                        $datos->idHeaderProcedureRecipeBook)) {
                            http_response_code(200);
                            echo "updated ProcedureRecipeBook";

                        }
                        else {
                            http_response_code(400);
                            echo "no updated ProcedureRecipeBook, check the changes o the id entered";

                        }
                    }
                    else {
                        http_response_code(405);
                        echo "internal error";

                    }
                    break;


           
                    case 'deleteProcedureRecipeBook':
                        $idProcedureRecipeBook=$_GET['idProcedureRecipeBook'];
        
                         if($idProcedureRecipeBook != NULL) {
        
        
                            if(procedureRecipeBook::deleteProcedureRecipeBook($idProcedureRecipeBook)) {
                              http_response_code(200);
                              echo "deleted ProcedureRecipeBook";
        
        
                          }
                        else {
                              http_response_code(400);
                              echo "no deleted ProcedureRecipeBook, check idProcedureRecipeBook o the id entered";
        
                          }
                      }
                      else {
                          http_response_code(405);
                          echo "internal error ";
                      }
                      break;
        
                

            case 'getAllProcedureRecipeBook':
                if(procedureRecipeBook::getAllProcedureRecipeBook()) {
                        http_response_code(200);
                        echo json_encode(ProcedureRecipeBook::getAllProcedureRecipeBook());
                                }
                else {
                        http_response_code(400);
                        echo "no data";
                        }
            break;


                
            case 'byIdProcedureBook':
                if(isset($_GET['idProcedureRecipeBook'])) {
                    $result = json_encode(ProcedureRecipeBook::byIdProcedureRecipeBook($_GET['idProcedureRecipeBook']));
                    $comprobacion=$result=="[]";
                    if($comprobacion==1){
                    echo "No ProcedureRecipeBook  was found with this id";
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
