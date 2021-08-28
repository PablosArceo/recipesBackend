<?php
    class ingredientRecipeBook extends Connection{

        
        public static function insertIngredientRecipeBook($ingredientDatail,$percentage,$quantityPounds,$quantityOunces,$idHeaderIngredientRecipeBook) {

            $db = new Connection();
            $query = "INSERT INTO ingredientRecipeBook (ingredientDatail,percentage,quantityPounds,quantityOunces,idHeaderIngredientRecipeBook)
            VALUES('".$ingredientDatail."','".$percentage."','".$quantityPounds."','".$quantityOunces."',$idHeaderIngredientRecipeBook)";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateIngredientRecipeBook($idIngredient, $ingredientDatail, $percentage, $quantityPounds,$quantityOunces,
            $idHeaderIngredientRecipeBook) {
            $db = new Connection();
            $query = "UPDATE ingredientRecipeBook SET
            ingredientDatail='".$ingredientDatail."', percentage='".$percentage."', quantityPounds='".$quantityPounds."',quantityOunces='".$quantityOunces."',
            idHeaderIngredientRecipeBook='".$idHeaderIngredientRecipeBook."'
            WHERE idIngredient=$idIngredient";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function deleteIngredientRecipeBook($idIngredient) {
            $db = new Connection();
            $query = "DELETE FROM ingredientRecipeBook WHERE idIngredient=$idIngredient";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getAllIngredientRecipeBook() {
            $db = new Connection();
            $query = "SELECT *FROM ingredientRecipeBook";
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
                        'idHeaderIngredientRecipeBook' => $row['idHeaderIngredientRecipeBook'],
                    ];
                }
                return $datos;
            }
            return $datos;
        }


        public static function byIdIngredientRecipeBook($idIngredient):array {
            $db = new Connection();
            $query = "SELECT *FROM ingredientRecipeBook WHERE idIngredient=$idIngredient";
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
                        'idHeaderIngredientRecipeBook' => $row['idHeaderIngredientRecipeBook'],
                    ];
                }
                return $datos;
                
            }
            else{
                return $datos;


            }
        }

    }
