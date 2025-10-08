<?php
    class Control {
        private $controlador = "Login";
        private $metodo = "caratula";
        private $parametros = [1,2,3];

        function __construct() {
            $url = $this->separarURL();
            Helper::mostrar($url);
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