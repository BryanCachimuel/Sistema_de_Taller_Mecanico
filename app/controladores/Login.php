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

        public function olvido() {
            $datos = [
                "titulo" => "Olvido de la clave de Acceso",
                "subtitulo" => "Olvidaste tu clave de acceso"
            ];
            $this->vista("loginOlvidoVista",$datos);
        }
    }

?>