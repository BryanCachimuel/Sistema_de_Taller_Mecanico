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
                    $data = $this->modelo->buscarCorreo($correo);
                    if($this->enviarCorreo($data)){
                        Helper::mostrar($correo);
                    }else {
                        array_push($errores, "Error al enviar el correo electrónico");
                    }        
                }
            }
            $datos = [
                "titulo" => "Olvido de la clave de Acceso",
                "subtitulo" => "Olvidaste tu clave de acceso",
                "errores" => $errores
            ];
            $this->vista("loginOlvidoVista",$datos);
        }

        public function enviarCorreo(array $data=[]):bool {
            $salida = false;
            if(!empty($data)) {
                $id = 1; // Helper::encriptar($data["id"]);
                $msg = "Entra en el siguiente enlace para cambiar tu clave de acceso al sistema de control de mi taller mecánico...<br>";
                $msg.= "<a href='".RUTA."login/cambiarclave/".$id."'>Cambiar tu clave de acceso</a>";

                $headers = "MIME-Version: 1.0\r\n"; 
			    $headers.= "Content-type:text/html; charset=UTF-8\r\n"; 
			    $headers.= "From: Taller Mecanico\r\n"; 
			    $headers.= "Reply-to: ayuda@taller.com\r\n";

			    $asunto = "Cambiar clave de acceso";
			    //Helper::mostrar($msg);
			    $salida = @mail($data["correo"],$asunto,$msg, $headers);
            }
            return $salida;
        }
    }

?>