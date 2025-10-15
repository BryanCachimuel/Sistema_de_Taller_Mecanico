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

        public function query(string $sql=''):array {
            if(empty($sql)) return [];
            $stmt = $this->conn->query($sql);
            $salida = $stmt->fetch(PDO::FETCH_ASSOC);
            if($salida) {
                return $salida;
            }
            return [];
        }

        // update, delete, insert
        public function queryNoSelect(string $sql, array $data=[]):bool {
            $salida = false;
            if(empty($data)){
                if($this->conn->query($sql)) $salida = true;
            }else {
                if($this->conn->prepare($sql)->execute($data)) $salida = true;
            }
            return $salida;
        }
    }
?>