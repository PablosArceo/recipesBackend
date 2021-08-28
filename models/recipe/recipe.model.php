<?php
    class recipe extends Connection{

        
        public static function insertRecipe($recipeName, $descriptionRecipe, $idAuth) {

            $db = new Connection();
            $query = "INSERT INTO recipe (recipeName,descriptionRecipe,idAuth)
            VALUES('".$recipeName."', '".$descriptionRecipe."','".$idAuth."')";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateRecipe($idRecipe, $recipeName, $descriptionRecipe, $idAuth) {
            $db = new Connection();
            $query = "UPDATE recipe SET
            recipeName='".$recipeName."', descriptionRecipe='".$descriptionRecipe."', idAuth='".$idAuth."' 
            WHERE idRecipe=$idRecipe";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteRecipe($idRecipe) {
            $db = new Connection();
            $query = "DELETE FROM recipe WHERE idRecipe=$idRecipe";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllRecipe() {
            $db = new Connection();
            $query = "SELECT *FROM recipe";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idRecipe' => $row['idRecipe'],
                        'recipeName' => $row['recipeName'],
                        'descriptionRecipe' => $row['descriptionRecipe'],
                        'idAuth' => $row['idAuth'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdRecipe($idRecipe):array {
            $db = new Connection();
            $query = "SELECT *FROM recipe WHERE idRecipe=$idRecipe";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idRecipe' => $row['idRecipe'],
                        'recipeName' => $row['recipeName'],
                        'descriptionRecipe' => $row['descriptionRecipe'],
                        'idAuth' => $row['idAuth'],
                    ];
                }
                return $datos;
                
            }
            else{
                return $datos;


            }
        }

    }
