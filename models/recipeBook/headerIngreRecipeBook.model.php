<?php
    class headerIngreRecipeBook extends Connection{

        
        public static function insertHeaderIngreRecipeBook($headerName, $idRecipeBook) {

            $db = new Connection();
            $query = "INSERT INTO headerIngredientRecipeBook (headerName,idRecipeBook)
            VALUES('".$headerName."', '".$idRecipeBook."')";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateHeaderIngreRecipeBook($idHeaderIngredientRecipeBook, $headerName, $idRecipeBook) {
            $db = new Connection();
            $query = "UPDATE headerIngredientRecipeBook SET
            headerName='".$headerName."', idRecipeBook='".$idRecipeBook."'
            WHERE idHeaderIngredientRecipeBook=$idHeaderIngredientRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteHeaderIngreRecipeBook($idHeaderIngredientRecipeBook) {
            $db = new Connection();
            $query = "DELETE FROM headerIngredientRecipeBook WHERE idHeaderIngredientRecipeBook=$idHeaderIngredientRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllHeaderIngreRecipeBook() {
            $db = new Connection();
            $query = "SELECT *FROM headerIngredientRecipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idHeaderIngredientRecipeBook' => $row['idHeaderIngredientRecipeBook'],
                        'headerName' => $row['headerName'],
                        'idRecipeBook' => $row['idRecipeBook'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdHeaderIngreRecipeBook($idHeaderIngredientRecipeBook):array {
            $db = new Connection();
            $query = "SELECT *FROM headerIngredientRecipeBook WHERE idHeaderIngredientRecipeBook=$idHeaderIngredientRecipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idHeaderIngredientRecipeBook' => $row['idHeaderIngredientRecipeBook'],
                        'headerName' => $row['headerName'],
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
