<?php
    class recipeBook extends Connection{

        
        public static function insertRecipeBook($recipeBookName, $performance, $descriptionRecipe, $idAuth ) {

            $db = new Connection();
            $query = "INSERT INTO recipeBook (recipeBookName,performance,descriptionRecipe,idAuth)
            VALUES('".$recipeBookName."', '".$performance."', '".$descriptionRecipe."','".$idAuth."')";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateRecipeBook($idRecipeBook, $recipeBookName, $performance, $descriptionRecipe, $idAuth) {
            $db = new Connection();
            $query = "UPDATE recipeBook SET
            recipeBookName='".$recipeBookName."', performance='".$performance."', descriptionRecipe='".$descriptionRecipe."', idAuth='".$idAuth."' 
            WHERE idRecipeBook=$idRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteRecipeBook($idRecipeBook) {
            $db = new Connection();
            $query = "DELETE FROM recipeBook WHERE idRecipeBook=$idRecipeBook";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllRecipeBook() {
            $db = new Connection();
            $query = "SELECT *FROM recipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idRecipeBook' => $row['idRecipeBook'],
                        'recipeBookName' => $row['recipeBookName'],
                        'performance' => $row['performance'],
                        'descriptionRecipe' => $row['descriptionRecipe'],
                        'idAuth' => $row['idAuth'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdRecipeBook($idRecipeBook):array {
            $db = new Connection();
            $query = "SELECT *FROM recipeBook WHERE idRecipeBook=$idRecipeBook";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idRecipeBook' => $row['idRecipeBook'],
                        'recipeBookName' => $row['recipeBookName'],
                        'performance' => $row['performance'],
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
