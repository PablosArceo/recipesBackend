<?php
    class procedureRecipe extends Connection{

        
        public static function insertProcedureRecipe($procedureRecipeStep, $idHeaderProcedureRecipe) {

            $db = new Connection();
            $query = "INSERT INTO procedureRecipe (procedureRecipeStep,idHeaderProcedureRecipe)
            VALUES('".$procedureRecipeStep."', '".$idHeaderProcedureRecipe."')";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }
        public static function updateProcedureRecipe($idProcedureRecipe, $procedureRecipeStep, $idHeaderProcedureRecipe) {
            $db = new Connection();
            $query = "UPDATE procedureRecipe SET
            procedureRecipeStep='".$procedureRecipeStep."', idHeaderProcedureRecipe='".$idHeaderProcedureRecipe."'
            WHERE idProcedureRecipe=$idProcedureRecipe";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteProcedureRecipe($idProcedureRecipe) {
            $db = new Connection();
            $query = "DELETE FROM procedureRecipe WHERE idProcedureRecipe=$idProcedureRecipe";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllProcedureRecipe() {
            $db = new Connection();
            $query = "SELECT *FROM procedureRecipe";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idProcedureRecipe' => $row['idProcedureRecipe'],
                        'procedureRecipeStep' => $row['procedureRecipeStep'],
                        'idHeaderProcedureRecipe' => $row['idHeaderProcedureRecipe'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdProcedureRecipe($idProcedureRecipe):array {
            $db = new Connection();
            $query = "SELECT *FROM procedureRecipe WHERE idProcedureRecipe=$idProcedureRecipe";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idProcedureRecipe' => $row['idProcedureRecipe'],
                        'procedureRecipeStep' => $row['procedureRecipeStep'],
                        'idHeaderProcedureRecipe' => $row['idHeaderProcedureRecipe'],
                    ];
                }
                return $datos;
                
            }
            else{
                return $datos;


            }
        }

    }
