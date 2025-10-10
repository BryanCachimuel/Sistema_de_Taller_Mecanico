<?php

    class LoginModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

    }

?>