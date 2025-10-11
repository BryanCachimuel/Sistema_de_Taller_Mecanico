<?php

    class Login extends Controlador{

        private $modelo = "";
        private $sesion;

        function __construct() {
            $this->modelo = $this->modelo("LoginModelo");
        }

        public function caratula() {
            $datos = [
                "titulo" => "Inicio de Sesión",
                "subtitulo" => "Taller Mecánico"
            ];
            $this->vista("loginCaratulaVista",$datos);
        }
    }

?>