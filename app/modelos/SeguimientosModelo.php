<?php  
/**
 * 
 */
class SeguimientosModelo {
	
    private $db="";
	
	function __construct() {
		$this->db = new MySQLdb();
	}

	public function alta(array $data=[]):bool {
		$salida = 0;
		$sql = "INSERT INTO seguimientos VALUES(0,";//1. id 
		$sql.= "'".$data['idOrdenReparacion']."', ";//2. idOrdenReparacion
		$sql.= "'".$data['fecha']."', "; 			//3. fecha
		$sql.= "'".$data['observacion']."', "; 		//4. observacion
		$sql.= "0) ";                   			//5. baja
		if ($this->db->queryNoSelect($sql)) {
			$salida = $this->db->query("SELECT LAST_INSERT_ID()");
			$salida = $salida["LAST_INSERT_ID()"];
		}
		return $salida;
	}

	public function bajaLogica(string $id):bool {
		$salida = false;
		$sql = "UPDATE seguimientos SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		$salida = $this->db->queryNoSelect($sql);
		return $salida;
	}

	public function getId(string $id=''):array {
		if(empty($id)) return [];
		$sql = "SELECT id, idOrdenReparacion, fecha, observacion ";
		$sql.= "FROM seguimientos ";
		$sql.= "WHERE id='".$id."' AND baja=0";
		return $this->db->query($sql);
	}

	public function getNumRegistros(string $tabla):int {
		$sql = "SELECT COUNT(*) FROM ".$tabla." WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTablaOrdenReparacion(int $inicio=1, int $tamano=0):array {
		$sql = "SELECT o.id, o.idVehiculo, o.fechaIngreso, o.fechaSalida, ";
		$sql.= "CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo ";
		$sql.= "FROM OrdenReparacion as o, Vehiculos as v ";
		$sql.= "WHERE o.baja=0 AND ";
		$sql.= "o.idVehiculo=v.id";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

    public function getTablaSeguimiento(int $inicio=1, int $tamano=0, string $idOrdenReparacion):array {
		$sql = "SELECT s.id, s.fecha, SUBSTRING(s.observacion, 1, 50) as observacion, ";
		$sql.= "CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo ";
		$sql.= "FROM Seguimientos as s, OrdenReparacion as o, Vehiculos as v ";
		$sql.= "WHERE s.idOrdenReparacion=o.id AND ";
		$sql.= "o.idVehiculo=v.id AND s.baja=0 AND s.idOrdenReparacion=".$idOrdenReparacion;
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}


	public function modificar(array $data):bool {
		$salida = false;
	    if (!empty($data["id"])) {
		    $sql = "UPDATE seguimientos SET "; 
			$sql.= "idOrdenReparacion='".$data['idOrdenReparacion']."', ";
			$sql.= "fecha='".$data['fecha']."', ";
			$sql.= "observacion='".$data['observacion']."' ";
			$sql.= "WHERE id=".$data['id'];
		    //Enviamos a la base de datos
		    $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}
}

?>