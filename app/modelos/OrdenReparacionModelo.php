<?php

    class OrdenReparacionModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function alta(array $data=[]):bool {
            $sql = "INSERT INTO ordenreparacion VALUES(0,";//1. id 
            $sql.= "'".$data['marca']."', "; 		//2. marca
            $sql.= "'".$data['modelo']."', "; 		//3. modelo
            $sql.= "'".$data['color']."', "; 		//4. color
            $sql.= "'".$data['anio']."', "; 		//5. año
            $sql.= "'".$data['placas']."', "; 		//6. placas
            $sql.= "'".$data['idCliente']."', "; 	//7. idCliente
            //
            $sql.= "0, ";                   //8. baja
            $sql.= "NOW(), ";               //9. fecha alta
            $sql.= "'', ";                  //10. fecha baja 
            $sql.= "'')";                   //11. fecha cambio
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