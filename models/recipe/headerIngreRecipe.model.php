<?php
class headerIngredientRecipe extends Connection
{


    public static function insertHeaderIngreRecipe($headerName, $idRecipe)
    {

        $db = new Connection();
        $query = "INSERT INTO headerIngredientRecipe (headerName,idRecipe)
            VALUES('" . $headerName . "', '" . $idRecipe . "')";
        $db->query($query);
        if ($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function updateHeaderIngreRecipe($idHeaderIngredientRecipe, $headerName, $idRecipe)
    {
        $db = new Connection();
        $query = "UPDATE headerIngredientRecipe SET
            headerName='" . $headerName . "', idRecipe='" . $idRecipe . "'
            WHERE idHeaderIngredientRecipe=$idHeaderIngredientRecipe";
        $db->query($query);
        if ($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function deleteHeaderIngreRecipe($idHeaderIngredientRecipe)
    {
        $db = new Connection();
        $query = "DELETE FROM headerIngredientRecipe WHERE idHeaderIngredientRecipe=$idHeaderIngredientRecipe";
        $db->query($query);
        if ($db->affected_rows) {
            return TRUE;
        }
        return FALSE;
    }

    public static function getAllHeaderIngreRecipe()
    {
        $db = new Connection();
        $query = "SELECT *FROM headerIngredientRecipe";
        $resultado = $db->query($query);
        $datos = [];
        if ($resultado->num_rows) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idHeaderIngredientRecipe' => $row['idHeaderIngredientRecipe'],
                    'headerName' => $row['headerName'],
                    'idRecipe' => $row['idRecipe'],
                ];
            }
            return $datos;
        }
        return $datos;
    }


    public static function byIdHeaderIngreRecipe($idHeaderIngredientRecipe): array
    {
        $db = new Connection();
        $query = "SELECT *FROM headerIngredientRecipe WHERE idHeaderIngredientRecipe=$idHeaderIngredientRecipe";
        $resultado = $db->query($query);
        $datos = [];
        if ($resultado->num_rows) {
            while ($row = $resultado->fetch_assoc()) {
                $datos[] = [
                    'idHeaderIngredientRecipe' => $row['idHeaderIngredientRecipe'],
                    'headerName' => $row['headerName'],
                    'idRecipe' => $row['idRecipe'],
                ];
            }
            return $datos;
        } else {
            return $datos;
        }
    }
}
