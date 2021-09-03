<!-- <?php
        require_once "../../utils/jwt.php";


        class recipe extends Connection
        {

            public static function globalService($sentQuery, $idAuth)
            {
                $db = new Connection();

                $secret_key = 'passAuth';
                $cabezera = getallheaders();
                $token = $cabezera["Authorization"];

                if ($token) {
                    $query2 = AuthNew::Check($token, $secret_key);

                    $idAuthVerify = get_object_vars($query2)["idAuth"];
                    if ($idAuthVerify == $idAuth) {
                        $query = $sentQuery;

                        $db->query($query);
                        return $db;
                    } else {
                        echo "You do not have the necessary permissions to enter a recipe";
                    }
                } else {
                    echo "the request does not have a token";
                }
            }



            public static function insertRecipe($recipeName, $descriptionRecipe, $idAuth)
            {
                $sentQuery = "INSERT INTO recipe (recipeName,descriptionRecipe,idAuth)
                VALUES('".$recipeName."', '".$descriptionRecipe."','".$idAuth."')";
                return self::globalService($sentQuery, $idAuth);
            }


            public static function updateRecipe($idRecipe, $recipeName, $descriptionRecipe, $idAuth)
            {
                $sentQuery = "UPDATE recipe SET
                recipeName='" . $recipeName .  "', descriptionRecipe='" . $descriptionRecipe . "', idAuth='" . $idAuth . "' 
                WHERE idRecipe=$idRecipe";
                return self::globalService($sentQuery, $idAuth);
            }


            public static function deleteRecipe($idRecipe)
            {
                $db = new Connection();
                $query2 = "SELECT idAuth FROM recipe WHERE idRecipe=$idRecipe";
                $resultQuery = $db->query($query2);
                $result = $resultQuery->fetch_array()[0] ?? "";

                $sentQuery = "DELETE FROM recipe WHERE idRecipe=$idRecipe";
                return self::globalService($sentQuery, $result);
            }

            
            public static function getAllRecipe()
            {
                $db = new Connection();
                $query = "SELECT *FROM recipe";
                $resultado = $db->query($query);
                $datos = [];
                if ($resultado->num_rows) {
                    while ($row = $resultado->fetch_assoc()) {
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


            public static function byIdRecipe($idRecipe): array
            {
                $db = new Connection();
                $query = "SELECT *FROM recipe WHERE idRecipe=$idRecipe";
                $resultado = $db->query($query);
                $datos = [];
                if ($resultado->num_rows) {
                    while ($row = $resultado->fetch_assoc()) {
                        $datos[] = [
                            'idRecipe' => $row['idRecipe'],
                            'recipeName' => $row['recipeName'],
                            'descriptionRecipe' => $row['descriptionRecipe'],
                            'idAuth' => $row['idAuth'],
                        ];
                    }
                    return $datos;
                } else {
                    return $datos;
                }
            }
        }
