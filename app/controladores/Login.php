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
            $errores = [];
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $correo = $_POST['correo']??"";
                if(empty($correo)){
                    array_push($errores, "El correo electrónico es requerido");
                }
                if(filter_var($correo, FILTER_VALIDATE_EMAIL) == false){
                    array_push($errores, "El correo electrónico no está bien escrito");
                }
                if(empty($errores)) {
                    Helper::mostrar($correo);
                }
                Helper::mostrar($errores);
            }
            $datos = [
                "titulo" => "Olvido de la clave de Acceso",
                "subtitulo" => "Olvidaste tu clave de acceso"
            ];
            $this->vista("loginOlvidoVista",$datos);
        }
    }

?>