<?php

    class LoginModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function actualizarClaveAcceso(array $data=[]):bool {
            if(!empty($data)) {
                $sql = "UPDATE usuarios SET clave=:clave WHERE id=:id";
                return $this->db->queryNoSelect($sql,$data);
            }  
            return false; 
        }

        public function buscarCorreo(string $correo=''): array {
            if($correo == "") return [];
            $sql = "SELECT id, tipoUsuario, nombres, apellidos, direccion, ";
            $sql.= "telefono, correo, clave, genero, estadoUsuario ";
            $sql.= "FROM usuarios ";
            $sql.= "WHERE correo = '".$correo."' AND baja=0";
            return $this->db->query($sql);
        }

    }

?>