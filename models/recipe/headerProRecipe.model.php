<?php
    class headerProRecipe extends Connection{

        
        public static function insertHeaderProRecipe($headerProcedure, $idRecipe) {

            $db = new Connection();
            $query = "INSERT INTO headerProcedureRecipe (headerProcedure,idRecipe)
            VALUES('".$headerProcedure."', '".$idRecipe."')";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateHeaderProRecipe($idHeaderProcedureRecipe, $headerProcedure, $idRecipe) {
            $db = new Connection();
            $query = "UPDATE headerProcedureRecipe SET
            headerProcedure='".$headerProcedure."', idRecipe='".$idRecipe."'
            WHERE idHeaderProcedureRecipe=$idHeaderProcedureRecipe";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteHeaderProRecipe($idHeaderProcedureRecipe) {
            $db = new Connection();
            $query = "DELETE FROM headerProcedureRecipe WHERE idHeaderProcedureRecipe=$idHeaderProcedureRecipe";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllHeaderProRecipe() {
            $db = new Connection();
            $query = "SELECT *FROM headerProcedureRecipe";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idHeaderProcedureRecipe' => $row['idHeaderProcedureRecipe'],
                        'headerProcedure' => $row['headerProcedure'],
                        'idRecipe' => $row['idRecipe'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdHeaderProRecipe($idHeaderProcedureRecipe):array {
            $db = new Connection();
            $query = "SELECT *FROM headerProcedureRecipe WHERE idHeaderProcedureRecipe=$idHeaderProcedureRecipe";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idHeaderProcedureRecipe' => $row['idHeaderProcedureRecipe'],
                        'headerProcedure' => $row['headerProcedure'],
                        'idRecipe' => $row['idRecipe'],
                    ];
                }
                return $datos;
                
            }
            else{
                return $datos;


            }
        }

    }
