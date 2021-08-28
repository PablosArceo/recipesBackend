<?php
    class ingredientRecipe extends Connection{

        
        public static function insertIngredientRecipe($ingredientDatail,$percentage,$quantityPounds,$quantityOunces,$idHeaderIngredientRecipe) {

            $db = new Connection();
            $query = "INSERT INTO ingredientRecipe (ingredientDatail,percentage,quantityPounds,quantityOunces,idHeaderIngredientRecipe)
            VALUES('".$ingredientDatail."','".$percentage."','".$quantityPounds."','".$quantityOunces."',$idHeaderIngredientRecipe)";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateIngredientRecipe($idIngredient, $ingredientDatail, $percentage, $quantityPounds,$quantityOunces,
            $idHeaderIngredientRecipe) {
            $db = new Connection();
            $query = "UPDATE ingredientRecipe SET
            ingredientDatail='".$ingredientDatail."', percentage='".$percentage."', quantityPounds='".$quantityPounds."',quantityOunces='".$quantityOunces."',
            idHeaderIngredientRecipe='".$idHeaderIngredientRecipe."'
            WHERE idIngredient=$idIngredient";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteIngredientRecipe($idIngredient) {
            $db = new Connection();
            $query = "DELETE FROM ingredientRecipe WHERE idIngredient=$idIngredient";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllIngredientRecipe() {
            $db = new Connection();
            $query = "SELECT *FROM ingredientRecipe";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idIngredient' => $row['idIngredient'],
                        'ingredientDatail' => $row['ingredientDatail'],
                        'percentage' => $row['percentage'],
                        'quantityPounds' => $row['quantityPounds'],
                        'quantityOunces' => $row['quantityOunces'],
                        'idHeaderIngredientRecipe' => $row['idHeaderIngredientRecipe'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdIngredientRecipe($idIngredient):array {
            $db = new Connection();
            $query = "SELECT *FROM ingredientRecipe WHERE idIngredient=$idIngredient";
            $resultado = $db->query($query);
            $datos = [];
            if($resultado->num_rows) {
                while($row = $resultado->fetch_assoc()) {
                    $datos[] = [
                        'idIngredient' => $row['idIngredient'],
                        'ingredientDatail' => $row['ingredientDatail'],
                        'percentage' => $row['percentage'],
                        'quantityPounds' => $row['quantityPounds'],
                        'quantityOunces' => $row['quantityOunces'],
                        'idHeaderIngredientRecipe' => $row['idHeaderIngredientRecipe'],
                    ];
                }
                return $datos;
                
            }
            else{
                return $datos;


            }
        }

    }
