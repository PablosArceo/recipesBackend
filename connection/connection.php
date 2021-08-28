<?php

class Connection extends Mysqli {
    function __construct() {
        parent:: __construct('localhost', 'root', '','recetariodatabase');
        $this->set_charset('utf8');
        $this->connect_error == NULL ? 'Conexion exitosa a la DB' :die('Error al conectarse a la DB');
    } 
}

?>