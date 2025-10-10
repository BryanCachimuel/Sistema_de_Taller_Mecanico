<?php

    class Controlador {
        
        function __construct() { }

        public function modelo($modelo='') {
            if (file_exists("../app/modelos/".$modelo.".php")) {
                require_once("../app/modelos/".$modelo.".php");
                return new $modelo;
            }else {
                die("El modelo ".$modelo." no existe");
            }
        }

    }

?>