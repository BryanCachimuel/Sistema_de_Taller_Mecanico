<?php

    class Sesion {

        private $login = false;
        private $usuario;

        function __construct() {
            session_start();
            if(isset($_SESSION['usuario'])) {
                $this->usuario = $_SESSION['usuario'];
                $this->login = true;
            }else {
                unset($this->usuario);
                $this->login = false;
            }
        }
    }


?>