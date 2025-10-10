<?php

    class Login extends Controlador{

        private $modelo = "";
        private $sesion;

        function __construct() {
            $this->modelo = $this->modelo("LoginModelo");
        }

        public function caratula() {
            $datos = [];
            $this->vista("loginCaratulaVista",$datos);
        }
    }

?>