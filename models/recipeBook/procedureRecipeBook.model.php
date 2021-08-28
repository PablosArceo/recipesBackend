<?php
    class procedureRecipeBook extends Connection{

        
        public static function insertProcedureRecipeBook($procedureRecipeBookStep, $idHeaderProcedureRecipeBook) {

            $db = new Connection();
            $query = "INSERT INTO procedureRecipeBook (procedureRecipeBookStep,idHeaderProcedureRecipeBook)
            VALUES('".$procedureRecipeBookStep."', '".$idHeaderProcedureRecipeBook."')";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }
        public static function updateProcedureRecipeBook($idProcedureRecipeBook, $procedureRecipeBookStep, $idHeaderProcedureRecipeBook) {
            $db = new Connection();
            $query = "UPDATE procedureRecipeBook SET
            procedureRecipeBookStep='".$procedureRecipeBookStep."', idHeaderProcedureRecipeBook='".$idHeaderProcedureRecipeBook."'
            WHERE idProcedureRecipeBook=$idProcedureRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteProcedureRecipeBook($idProcedureRecipeBook) {
            $db = new Connection();
            $query = "DELETE FROM procedureRecipeBook WHERE idProcedureRecipeBook=$idProcedureRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllProcedureRecipeBook() {
            $db = new Connection();
            $query = "SELECT *FROM procedureRecipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idProcedureRecipeBook' => $row['idProcedureRecipeBook'],
                        'procedureRecipeBookStep' => $row['procedureRecipeBookStep'],
                        'idHeaderProcedureRecipeBook' => $row['idHeaderProcedureRecipeBook'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdProcedureRecipeBook($idProcedureRecipeBook):array {
            $db = new Connection();
            $query = "SELECT *FROM procedureRecipeBook WHERE idProcedureRecipeBook=$idProcedureRecipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idProcedureRecipeBook' => $row['idProcedureRecipeBook'],
                        'procedureRecipeBookStep' => $row['procedureRecipeBookStep'],
                        'idHeaderProcedureRecipeBook' => $row['idHeaderProcedureRecipeBook'],
                    ];
                }
                return $datos;
                
            }
            else{
                return $datos;


            }
        }

    }
