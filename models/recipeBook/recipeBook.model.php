<!-- <?php
        require_once "../../utils/jwt.php";


        class recipeBook extends Connection
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
                    echo "the request does not have a token ";
                }
            }



            public static function insertRecipeBook($recipeBookName, $performance, $descriptionRecipe, $idAuth)
            {
                $sentQuery = "INSERT INTO recipeBook (recipeBookName,performance,descriptionRecipe,idAuth)
                VALUES('" . $recipeBookName . "', '" . $performance . "', '" . $descriptionRecipe . "','" . $idAuth . "')";
                return self::globalService($sentQuery, $idAuth);
            }


            public static function updateRecipeBook($idRecipeBook, $recipeBookName, $performance, $descriptionRecipe, $idAuth)
            {
                $sentQuery = "UPDATE recipeBook SET
                recipeBookName='" . $recipeBookName . "', performance='" . $performance . "', descriptionRecipe='" . $descriptionRecipe . "', idAuth='" . $idAuth . "' 
                WHERE idRecipeBook=$idRecipeBook";
                return self::globalService($sentQuery, $idAuth);
            }


            public static function deleteRecipeBook($idRecipeBook)
            {
                $db = new Connection();
                $query2 = "SELECT idAuth FROM recipeBook WHERE idRecipeBook=$idRecipeBook";
                $resultQuery = $db->query($query2);
                $result = $resultQuery->fetch_array()[0] ?? "";

                $sentQuery = "DELETE FROM recipeBook WHERE idRecipeBook=$idRecipeBook";
                return self::globalService($sentQuery, $result);
            }

            
            public static function getAllRecipeBook()
            {
                $db = new Connection();
                $query = "SELECT *FROM recipeBook";
                $resultado = $db->query($query);
                $datos = [];
                if ($resultado->num_rows) {
                    while ($row = $resultado->fetch_assoc()) {
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


            public static function byIdRecipeBook($idRecipeBook): array
            {
                $db = new Connection();
                $query = "SELECT *FROM recipeBook WHERE idRecipeBook=$idRecipeBook";
                $resultado = $db->query($query);
                $datos = [];
                if ($resultado->num_rows) {
                    while ($row = $resultado->fetch_assoc()) {
                        $datos[] = [
                            'idRecipeBook' => $row['idRecipeBook'],
                            'recipeBookName' => $row['recipeBookName'],
                            'performance' => $row['performance'],
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
