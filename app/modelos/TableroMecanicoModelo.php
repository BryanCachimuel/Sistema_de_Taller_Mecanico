<?php  

class TableroMecanicoModelo {
	private $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function getNumRegistros(string $tabla, string $id):int {
		$sql = "SELECT COUNT(*) FROM ".$tabla." WHERE baja=0 AND idMecanico=".$id;
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTablaOrdenReparacion(int $inicio=1, int $tamano=0, string $id):array {
		$sql = "SELECT o.id, o.idVehiculo, o.fechaIngreso, o.fechaSalida,  ";
		$sql.= "CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo, e.estado, o.estado as edo ";
		$sql.= "FROM OrdenReparacion as o, Vehiculos as v, EstadoOrdenReparacion as e ";
		$sql.= "WHERE o.baja=0 AND ";
		$sql.= "o.idVehiculo=v.id AND ";
		$sql.= "o.estado=e.id AND o.idMecanico=".$id;
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

}

?>