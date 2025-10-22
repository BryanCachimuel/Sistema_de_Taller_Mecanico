<?php

    class MecanicosModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function alta(array $data=[]):int {
           $salida = 0;
		    $sql = "INSERT INTO mecanicos VALUES(0,"; //1. id 
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

        public function bajaLogica(string $id):bool {
            $salida = false;
            $sql = "UPDATE mecanicos SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
            $salida = $this->db->queryNoSelect($sql);
            return $salida;
        }

        public function getId(string $id=''):array {
            if(empty($id)) return [];
            $sql = "SELECT id, tipoUsuario, nombres, apellidos, direccion, telefono, ";
            $sql.= "correo, clave, genero, estadoUsuario FROM usuarios ";
            $sql.= "WHERE id='".$id."' AND baja=0";
            return $this->db->query($sql);
        }

        public function getNumRegistros():int {
            $sql = "SELECT COUNT(*) FROM mecanicos WHERE baja=0";
            $salida = $this->db->query($sql);
            return $salida["COUNT(*)"];
        }

        public function getTabla(int $inicio=1, int $tamano=0):array {
            $sql = "SELECT m.id, CONCAT(m.apellidos,' ',m.nombres) as nombre, ";
            $sql.= "tm.tipo, em.estado ";
            $sql.= "FROM mecanicos as m, tipoMecanico as tm, estadoMecanico as em ";
            $sql.= "WHERE m.baja=0 AND ";
            $sql.= "m.estado = em.id AND ";
            $sql.= "m.idTipoMecanico=tm.id";
            if($tamano>0) {
                $sql.= " LIMIT ".$inicio.", ".$tamano;
            }
            return $this->db->querySelect($sql);
        }

        public function getTipoMecanico() {
            $sql = "SELECT id, tipo FROM tipoMecanico";
            return $this->db->querySelect($sql);
        }

        public function getEstadoMecanico() {
            $sql = "SELECT id, estado FROM estadoMecanico";
            return $this->db->querySelect($sql);
        }

         public function getCorreo(string $correo=""):array {
            $sql = "SELECT id FROM mecanicos WHERE correo='".$correo."' AND baja=0";
            return $this->db->query($sql);
        }

        public function modificar(array $data):bool {
            $salida = false;
            if(!empty($data["id"])) {
                $sql = "UPDATE mecanicos SET ";
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