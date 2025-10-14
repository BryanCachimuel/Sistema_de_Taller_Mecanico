<?php

    class Controlador {
        
        function __construct() { }

        public function modelo(string $modelo='') {
            if (file_exists("../app/modelos/".$modelo.".php")) {
                require_once("../app/modelos/".$modelo.".php");
                return new $modelo;
            }else {
                die("El modelo ".$modelo." no existe");
            }
        }

        public function vista($vista='',$datos=[]) {
            if (file_exists("../app/vistas/".$vista.".php")) {
                require_once("../app/vistas/".$vista.".php");
            }else {
                die("La vista ".$vista." no existe");
            }
        }

        public function mensaje($titulo="",$subtitulo, $texto, $url, $color, $url2="",$color2="", $texto2="") {
            $datos = [
                "titulo" => $titulo,
                "menu" => true,
                "errores" => [],
                "data" => [],
                "subtitulo" => $subtitulo,
                "texto" => $texto,
                "url" => $url,
                "color" => "alert-".$color,
                "colorBoton" => "btn-".$color,
                "textoBoton" => "Regresar",
                "url2" => $url2,
                "colorBoton2" => "btn-".$color2,
                "textoBoton2" => $texto2
            ];
            $this->vista("mensaje",$datos);
            exit;
        }

    }

?>