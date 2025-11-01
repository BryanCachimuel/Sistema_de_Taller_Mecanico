<?php

    class OrdenAlmacenModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function altaOrdenAlmacen(string $idOrdenReparacion='',string $observacion=''):int {
            $salida = 0;
            $sql = "INSERT INTO ordenAlmacen VALUES(0,"; //1. id
            $sql.= "'".$idOrdenReparacion."', ";//2. tipo movimiento
            $sql.= "0, ";	 					//3. costo
            $sql.= "'".$observacion."', ";		//4. cantidad
            //
            $sql.= "0, ";                   	 //5. baja
            $sql.= "NOW(), ";               	 //6. fecha alta
            $sql.= "'', ";                  	 //7. fecha baja 
            $sql.= "'')";                   	 //8. fecha cambio
            if($this->db->queryNoSelect($sql)){
                $salida = $this->db->query("SELECT LAST_INSERT_ID()");
                $salida = $salida["LAST_INSERT_ID()"];
            }
            return $salida;
	    }

        public function bajaLogica(string $id):bool {
            $salida = false;
            $sql = "UPDATE ordenalmacen SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
            $salida = $this->db->queryNoSelect($sql);
            return $salida;
        }

        public function getId(string $id=''):array {
           if(empty($id)) return [];
            $sql = "SELECT id, idOrdenReparacion, costo, observacion, alta_dt ";
            $sql.= "WHERE id='".$id."' AND baja=0";
            return $this->db->query($sql);
        }

        public function getOrdenesReparacion() {
            $sql = "SELECT o.id, v.id, ";
            $sql.= "CONCAT(v.marca,' ',v.modelo,' ',v.color,' ',v.anio) as auto ";
            $sql.= "FROM ordenreparacion as o, vehiculos as v ";
            $sql.= "WHERE o.baja=0 AND o.estado=".ORDEN_ABIERTA;
            $sql.= " AND o.idVehiculo=v.id";
            return $this->db->querySelect($sql);
        }

        public function getPiezas():array {
            $sql = "SELECT id, nombrePieza, stock ";
            $sql.= "FROM piezas ";
            $sql.= "WHERE baja=0 AND stock > 0";
            return $this->db->querySelect($sql);
	    }

        public function getPieza():array {
            if(empty($id)) return [];
            $sql = "SELECT id, nombrePieza, stock, costo ";
            $sql.= "FROM piezas ";
            $sql.= "WHERE id='".$id."' AND baja=0";
            return $this->db->querySelect($sql);
	    }

        public function getNumRegistros():int {
            $sql = "SELECT COUNT(*) FROM ordenalmacen WHERE baja=0";
            $salida = $this->db->query($sql);
            return $salida["COUNT(*)"];
        }

        public function getTabla(int $inicio=1, int $tamano=0):array {
            $sql = "SELECT o.id, o.idOrdenReparacion, o.costo, o.alta_dt ";
            $sql.= "FROM ordenalmacen as o ";
            $sql.= "WHERE o.baja=0 ";
            if ($tamano>0) {
                $sql.= " LIMIT ".$inicio.", ".$tamano;
            }
            return $this->db->querySelect($sql);
	    }

        public function modificar(array $data):bool {
            $salida = false;
            if (!empty($data["id"])) {
                $sql = "UPDATE ordenalmacen SET "; 
                $sql.= "idVehiculo='".$data['idVehiculo']."', ";
                $sql.= "idMecanico='".$data['idMecanico']."', ";
                $sql.= "fechaIngreso='".$data['fechaIngreso']."', ";
                $sql.= "fechaSalida='".$data['fechaSalida']."', ";
                $sql.= "kilometraje='".$data['kilometraje']."', ";;
                $sql.= "gato='".$data['gato']."', ";
                $sql.= "herramientas='".$data['herramientas']."', ";
                $sql.= "triangulos='".$data['triangulos']."', ";
                $sql.= "refaccion='".$data['refaccion']."', ";
                $sql.= "extintor='".$data['extintor']."', ";
                $sql.= "antena='".$data['antena']."', ";
                $sql.= "emblemas='".$data['emblemas']."', ";
                $sql.= "tapones='".$data['tapones']."', ";
                $sql.= "cables='".$data['cables']."', ";
                $sql.= "estereo='".$data['estereo']."', ";
                $sql.= "encendedor='".$data['encendedor']."', ";
                $sql.= "tapetes='".$data['tapetes']."', ";
                $sql.= "cambio_dt=(NOW()) ";
                $sql.= "WHERE id=".$data['id'];
                //Enviamos a la base de datos
                $salida = $this->db->queryNoSelect($sql);
            }
            return $salida;
        }
    }

?>