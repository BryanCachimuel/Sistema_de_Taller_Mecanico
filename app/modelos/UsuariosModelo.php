<?php

    class UsuariosModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function alta(array $data=[]):int {
           $salida = 0;
		    $sql = "INSERT INTO usuarios VALUES(0,"; //1. id 
            $sql.= "'".$data['tipoUsuario']."', "; 	//2. tipoUsuario
            $sql.= "'".$data['nombres']."', "; 		//3. nombre
            $sql.= "'".$data['apellidos']."', "; 	//4. apellidos
            $sql.= "'".$data['direccion']."', "; 	//5. direccion
            $sql.= "'".$data['telefono']."', "; 	//6. telefono
            $sql.= "'".$data['correo']."', "; 		//7. correo
            $sql.= "'".$data['clave']."', "; 		//8. clave
            $sql.= "'".$data['genero']."', "; 		//9. genero
            $sql.= "'".$data['estadoUsuario']."', ";//10. estadoUsuario
            //
            $sql.= "0, ";                   //11. baja
            $sql.= "'', ";                  //12. fecha login
            $sql.= "NOW(), ";               //13. fecha alta
            $sql.= "'', ";                  //14. fecha baja 
            $sql.= "'')";                   //15. fecha cambio
            if($this->db->queryNoSelect($sql)){
                $salida = $this->db->query("SELECT LAST_INSERT_ID()");
                $salida = $salida["LAST_INSERT_ID()"];
            }
            return $salida;
        }

        public function getId(string $id=''):array {
            if(empty($id)) return [];
            $sql = "SELECT id, tipoUsuario, nombres, apellidos, direccion, telefono, ";
            $sql.= "correo, clave, genero, estadoUsuario FROM usuarios ";
            $sql.= "WHERE id='".$id."' AND baja=0";
            return $this->db->query($sql);
        }

        public function getTabla() {
            $sql = "SELECT u.id, CONCAT(u.apellidos,' ',u.nombres) as nombre, ";
            $sql.= "tu.tipoUsuario, eu.estado ";
            $sql.= "FROM usuarios as u, tipoUsuario as tu, estadoUsuario as eu ";
            $sql.= "WHERE u.baja=0 AND ";
            $sql.= "u.estadoUsuario = eu.id AND ";
            $sql.= "u.tipoUsuario=tu.id";
            return $this->db->querySelect($sql);
        }

        public function getTipoUsuarios() {
            $sql = "SELECT id, tipoUsuario FROM tipoUsuario";
            return $this->db->querySelect($sql);
        }

        public function getEstadosUsuarios() {
            $sql = "SELECT id, estado FROM estadoUsuario";
            return $this->db->querySelect($sql);
        }

        public function getGeneros() {
            $sql = "SELECT id, genero FROM generos";
            return $this->db->querySelect($sql);
        }

        public function getCorreo(string $correo='') {
            if(empty($correo)) return false;
            $sql = "SELECT id FROM usuarios WHERE correo='".$correo."' AND baja=0";
            return $this->db->query($sql);
        }

        public function modificar(array $data):bool {
            $salida = false;
            if(!empty($data["id"])) {
                $sql = "UPDATE usuarios SET ";
                $sql.= "tipoUsuario='".$data['tipoUsuario']."', ";
                $sql.= "nombres='".$data['nombres']."', ";
                $sql.= "apellidos='".$data['apellidos']."', ";
                $sql.= "direccion='".$data['direccion']."', ";
                $sql.= "telefono='".$data['telefono']."', ";
                $sql.= "correo='".$data['correo']."', ";
                $sql.= "genero='".$data['genero']."', ";
                $sql.= "cambio_dt=(NOW()) ";
                $sql.= "WHERE id=".$data['id'];
                // enviar a la base de datos
                $salida = $this->db->queryNoSelect($sql);
            }
            return $salida;
        }
    }

?>