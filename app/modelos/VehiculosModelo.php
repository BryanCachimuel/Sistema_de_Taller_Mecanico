<?php

    class VehiculosModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function alta(array $data=[]):bool {
            $sql = "INSERT INTO vehiculos VALUES(0,";//1. id 
            $sql.= "'".$data['nombres']."', "; 		//2. nombre
            $sql.= "'".$data['apellidos']."', "; 	//3. apellidos
            $sql.= "'".$data['razonSocial']."', "; 	//4. razonSocial
            $sql.= "'".$data['direccion']."', "; 	//5. direccion
            $sql.= "'".$data['telefono']."', "; 	//6. rfc
            $sql.= "'".$data['rfc']."', "; 			//7. telefono
            $sql.= "'".$data['correo']."', "; 		//8. correo
            $sql.= "'".$data['clave']."', "; 		//9. clave
            $sql.= "'".$data['estado']."', ";		//10. estadoUsuario
            //
            $sql.= "0, ";                   //11. baja
            $sql.= "'', ";                  //12. fecha login
            $sql.= "NOW(), ";               //13. fecha alta
            $sql.= "'', ";                  //14. fecha baja 
            $sql.= "'')";                   //15. fecha cambio
            return $this->db->queryNoSelect($sql);
        }

        public function bajaLogica(string $id):bool {
            $salida = false;
            $sql = "UPDATE vehiculos SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
            $salida = $this->db->queryNoSelect($sql);
            return $salida;
        }

        public function getId(string $id=''):array {
           if(empty($id)) return [];
            $sql = "SELECT id, nombres, apellidos, telefono, ";
            $sql.= "correo, clave, razonSocial, rfc, direccion, estado ";
            $sql.= "FROM vehiculos ";
            $sql.= "WHERE id='".$id."' AND baja=0";
            return $this->db->query($sql);
        }

        public function getNumRegistros():int {
            $sql = "SELECT COUNT(*) FROM vehiculos WHERE baja=0";
            $salida = $this->db->query($sql);
            return $salida["COUNT(*)"];
        }

        public function getClientes():array {
            $sql = "SELECT id, CONCAT(nombres,' ',apellidos,', ',razonSocial) as cliente ";
            $sql.= "FROM clientes WHERE baja=0 AND estado=".CLIENTE_ACTIVO." ";
            $sql.= "ORDER BY nombres,apellidos,razonSocial";
            return $this->db->querySelect($sql);
        }

        public function getTabla(int $inicio=1, int $tamano=0):array {
            $sql = "SELECT v.id, CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo, ";
            $sql.= "CONCAT(c.apellidos,' ',c.nombres) as nombre ";
            $sql.= "FROM vehiculos as v, clientes as c ";
            $sql.= "WHERE v.baja=0 AND ";
            $sql.= "v.idCliente=c.id ";
            if ($tamano>0) {
                $sql.= " LIMIT ".$inicio.", ".$tamano;
            }
            return $this->db->querySelect($sql);
	    }

        public function modificar(array $data):bool {
            $salida = false;
            if (!empty($data["id"])) {
                $sql = "UPDATE vehiculos SET "; 
                $sql.= "nombres='".$data['nombres']."', ";
                $sql.= "apellidos='".$data['apellidos']."', ";
                $sql.= "telefono='".$data['telefono']."', ";
                $sql.= "correo='".$data['correo']."', ";
                $sql.= "estado='".$data['estado']."', ";
                $sql.= "direccion='".$data['direccion']."', ";
                $sql.= "razonSocial='".$data['razonSocial']."', ";
                $sql.= "rfc='".$data['rfc']."', ";
                $sql.= "cambio_dt=(NOW()) ";
                $sql.= "WHERE id=".$data['id'];
                //Enviamos a la base de datos
                $salida = $this->db->queryNoSelect($sql);
            }
            return $salida;
        }
    }

?>