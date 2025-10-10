<?php
    class MySQLdb {

        private $host="localhost";
        private $usuario = "root";
        private $clave = "";
        private $db = "taller";
        private $puerto = "";
        private $conn;

        function __construct() {
           try {
            $this->conn = new PDO(
                'mysql:host='.$this->host.';dbname='.$this->db, 
                $this->usuario,
                $this->clave
            );
            //echo "Conectado";
           } catch (Exception $e) {
                die("No se pudo conectar: ".$e->getMessage());
           }
        }
    }
?>