<?php
    class Control {
        private $controlador = "Login";
        private $metodo = "caratula";
        private $parametros = [1,2,3];

        function __construct() {
            print "<h2>Bienvenidos al taller mecánico</h2>";
        }
    }
?>