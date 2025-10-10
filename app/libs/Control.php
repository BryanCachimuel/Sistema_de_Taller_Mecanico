<?php
    class Control {
        private $controlador = "Login";
        private $metodo = "caratula";
        private $parametros = [1,2,3];

        function __construct() {
            $url = $this->separarURL();
            if($url != [] && file_exists("../app/controladores/".ucwords($url[0]).".php")) {
                $this->controlador = ucwords($url[0]);
                unset($url[0]);
            }
            // cargar la clase controladora
            require_once("../app/controladores/".ucwords($this->controlador).".php");
            // crear la instancia
            $this->controlador = new $this->controlador;
            // verificar el método
            if(isset($url[1])) {
                if(method_exists($this->controlador, $url[1])){
                    $this->metodo = $url[1];
                    unset($url[1]);
                }
            }
            // parámetros
            $this->parametros = $url ? array_values($url) : [];
            // ejecutar el método
            call_user_func_array([$this->controlador,$this->metodo], $this->parametros);
        }

        public function separarURL():array {
            $url = [];
            if(isset($_GET['url'])) {
                // eliminar el caracter final
                $url = rtrim($_GET['url'], "/");
                $url = rtrim($_GET['url'], "\\");
                // sanitizar (quita todos los caracteres que no pertenezcan al inglés)
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode("/",$url);
            }
            return $url;
        } 
    }
?>