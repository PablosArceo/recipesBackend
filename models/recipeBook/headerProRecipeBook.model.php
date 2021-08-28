<?php
    class headerProRecipeBook extends Connection{

        
        public static function insertHeaderProRecipeBook($headerProcedure, $idRecipeBook) {

            $db = new Connection();
            $query = "INSERT INTO headerProcedureRecipeBook (headerProcedure,idRecipeBook)
            VALUES('".$headerProcedure."', '".$idRecipeBook."')";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateHeaderProRecipeBook($idHeaderProcedureRecipeBook, $headerProcedure, $idRecipeBook) {
            $db = new Connection();
            $query = "UPDATE headerProcedureRecipeBook SET
            headerProcedure='".$headerProcedure."', idRecipeBook='".$idRecipeBook."'
            WHERE idHeaderProcedureRecipeBook=$idHeaderProcedureRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteHeaderProRecipeBook($idHeaderProcedureRecipeBook) {
            $db = new Connection();
            $query = "DELETE FROM headerProcedureRecipeBook WHERE idHeaderProcedureRecipeBook=$idHeaderProcedureRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllHeaderProRecipeBook() {
            $db = new Connection();
            $query = "SELECT *FROM headerProcedureRecipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idHeaderProcedureRecipeBook' => $row['idHeaderProcedureRecipeBook'],
                        'headerProcedure' => $row['headerProcedure'],
                        'idRecipeBook' => $row['idRecipeBook'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdHeaderProRecipeBook($idHeaderProcedureRecipeBook):array {
            $db = new Connection();
            $query = "SELECT *FROM headerProcedureRecipeBook WHERE idHeaderProcedureRecipeBook=$idHeaderProcedureRecipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idHeaderProcedureRecipeBook' => $row['idHeaderProcedureRecipeBook'],
                        'headerProcedure' => $row['headerProcedure'],
                        'idRecipeBook' => $row['idRecipeBook'],
                    ];
                }
                return $datos;
                
            }
            else{
                return $datos;


            }
        }

    }
