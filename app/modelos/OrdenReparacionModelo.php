<?php

    class OrdenReparacionModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function alta(array $data=[]):bool {
            $sql = "INSERT INTO ordenreparacion VALUES(0,";//1. id 
            $sql.= "'".$data['idVehiculo']."', "; 		//2. idVehiculo
            $sql.= "'".$data['idMecanico']."', "; 		//3. idMecanico
            $sql.= "'".$data['fechaIngreso']."', "; 	//4. fechaIngreso
            $sql.= "'".$data['fechaSalida']."', "; 		//5. fechaSalida
            $sql.= "'".$data['kilometraje']."', "; 		//6. kilometraje
            $sql.= "'".$data['gato']."', "; 			//7. gato
            $sql.= "'".$data['herramientas']."', "; 	//8. herramientas
            $sql.= "'".$data['triangulos']."', "; 		//9. triangulos
            $sql.= "'".$data['refaccion']."', "; 		//10. refaccion
            $sql.= "'".$data['extintor']."', "; 		//11. extintor
            $sql.= "'".$data['antena']."', "; 			//12. antena
            $sql.= "'".$data['emblemas']."', "; 		//13. emblemas
            $sql.= "'".$data['tapones']."', "; 			//14. tapones
            $sql.= "'".$data['cables']."', "; 			//15. cables
            $sql.= "'".$data['estereo']."', "; 			//16. estereo
            $sql.= "'".$data['encendedor']."', "; 		//17. encendedor
            $sql.= "'".$data['tapetes']."', "; 			//18. tapetes
            $sql.= "'".ORDEN_ABIERTA."', "; 			//19. tapones
            //
            $sql.= "0, ";                   //20. baja
            $sql.= "NOW(), ";               //21. fecha alta
            $sql.= "'', ";                  //22. fecha baja 
            $sql.= "'')";                   //23. fecha cambio
            return $this->db->queryNoSelect($sql);
        }

        public function bajaLogica(string $id):bool {
            $salida = false;
            $sql = "UPDATE ordenreparacion SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
            $salida = $this->db->queryNoSelect($sql);
            return $salida;
        }

        public function getId(string $id=''):array {
           if(empty($id)) return [];
            $sql = "SELECT id, marca, modelo, color, ";
            $sql.= "anio, placas, idCliente ";
            $sql.= "FROM ordenreparacion ";
            $sql.= "WHERE id='".$id."' AND baja=0";
            return $this->db->query($sql);
        }

        public function getVehiculos():array {
            $sql = "SELECT id, CONCAT(marca,' ', modelo,' ', anio) AS vehiculo FROM vehiculos WHERE baja=0";
            return $this->db->querySelect($sql);
        }

        public function getMecanicos():array {
            $sql = "SELECT id, CONCAT(nombres, ' ', apellidos) AS mecanicos ";
            $sql.= "FROM mecanicos ";
            $sql.= "WHERE baja=0 AND estado=".MECANICO_DISPONIBLE;
            return $this->db->querySelect($sql);
        }

        public function getNumRegistros():int {
            $sql = "SELECT COUNT(*) FROM ordenreparacion WHERE baja=0";
            $salida = $this->db->query($sql);
            return $salida["COUNT(*)"];
        }

        public function getTabla(int $inicio=1, int $tamano=0):array {
            $sql = "SELECT v.id, CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo, ";
            $sql.= "o.id, o.idVehiculo, o.fechaIngreso, o.fechaSalida ";
            $sql.= "FROM ordenreparacion as o, vehiculos as v ";
            $sql.= "WHERE o.baja=0 AND o.estado=".ORDEN_ABIERTA." AND ";
            $sql.= "o.idVehiculo=v.id ";
            if ($tamano>0) {
                $sql.= " LIMIT ".$inicio.", ".$tamano;
            }
            return $this->db->querySelect($sql);
	    }

        public function modificar(array $data):bool {
            $salida = false;
            if (!empty($data["id"])) {
                $sql = "UPDATE ordenreparacion SET "; 
                $sql.= "marca='".$data['marca']."', ";
                $sql.= "modelo='".$data['modelo']."', ";
                $sql.= "color='".$data['color']."', ";
                $sql.= "anio='".$data['anio']."', ";
                $sql.= "placas='".$data['placas']."', ";
                $sql.= "idCliente='".$data['idCliente']."', ";;
                $sql.= "cambio_dt=(NOW()) ";
                $sql.= "WHERE id=".$data['id'];
                //Enviamos a la base de datos
                $salida = $this->db->queryNoSelect($sql);
            }
            return $salida;
        }
    }

?>