<?php  
/**
 * 
 */
class TableroClienteModelo {
	private $db="";
	
	function __construct() {
		$this->db = new MySQLdb();
	}

	public function getNumRegistros(string $tabla, string $id):int {
		$sql = "SELECT COUNT(*) FROM ".$tabla." WHERE baja=0 AND idCliente=".$id;
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getId(string $id=''):array {
		if(empty($id)) return [];
		$sql = "SELECT o.id, o.idVehiculo, o.idMecanico, o.fechaIngreso, o.fechaSalida, ";
		$sql.= "o.kilometraje, o.gato, o.herramientas, o.triangulos, o.refaccion, o.extintor, ";
		$sql.= "o.antena, o.emblemas, o.tapones, o.cables, o.estereo, o.encendedor, o.tapetes, ";
		$sql.= "o.estado, CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo, ";
		$sql.= "CONCAT(m.nombres,' ',m.apellidos) as mecanico, e.estado as edo ";
		$sql.= "FROM ordenreparacion as o, vehiculos as v, mecanicos as m, EstadoOrdenReparacion as e ";
		$sql.= "WHERE o.id='".$id."' AND o.baja=0 AND o.estado=e.id AND ";
		$sql.= "o.idVehiculo=v.id AND o.idMecanico=m.id";
		return $this->db->query($sql);
	}

	public function getSeguimientoId(string $id=''):array {
		if(empty($id)) return [];
		$sql = "SELECT id, idOrdenReparacion, fecha, observacion ";
		$sql.= "FROM seguimientos ";
		$sql.= "WHERE id='".$id."' AND baja=0";
		return $this->db->query($sql);
	}

	public function getPiezas(string $idOrdenReparacion=''):array {
		if(empty($idOrdenReparacion)) return [];
		$sql = "SELECT  a.idOrdenReparacion, p.nombrePieza, d.cantidad, p.costo ";
		$sql.= "FROM ordenAlmacen as a, ordenAlmacenDetalle as d, piezas as p ";
		$sql.= "WHERE a.idOrdenReparacion=".$idOrdenReparacion." AND ";
		$sql.= "a.id=d.idOrdenAlmacen AND ";
		$sql.= "d.idPieza=p.id";
		return $this->db->querySelect($sql);
	}

	public function getSeguimientos(string $idOrdenReparacion):array {
		$sql = "SELECT s.id, s.fecha, SUBSTRING(s.observacion, 1, 50) as observacion, ";
		$sql.= "CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo ";
		$sql.= "FROM Seguimientos as s, OrdenReparacion as o, Vehiculos as v ";
		$sql.= "WHERE s.idOrdenReparacion=o.id AND ";
		$sql.= "o.idVehiculo=v.id AND s.baja=0 AND s.idOrdenReparacion=".$idOrdenReparacion;
		return $this->db->querySelect($sql);
	}

	public function getTablaOrdenReparacion(string $id):array {
		$sql = "SELECT o.id, o.idVehiculo, o.fechaIngreso, o.fechaSalida,  ";
		$sql.= "CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo, e.estado, o.estado as edo ";
		$sql.= "FROM Clientes as c, OrdenReparacion as o, Vehiculos as v, EstadoOrdenReparacion as e ";
		$sql.= "WHERE o.baja=0 AND c.id=".$id." AND ";
		$sql.= "o.idVehiculo=v.id AND ";
		$sql.= "o.estado=e.id AND v.idCliente=c.id";
		return $this->db->querySelect($sql);
	}

	public function setUsuario($id, $nombres, $apellidos, $clave) {
		$sql = "UPDATE clientes SET ";
		$sql.= "nombres='".$nombres."', ";
		$sql.= "apellidos='".$apellidos."' ";
		if ($clave!="") {
			$sql.= ", clave='".$clave."' ";
		}
		$sql.= "WHERE id=".$id;
		return $this->db->queryNoSelect($sql);
	}

	public function getUsuarioId($id='') {
		$sql = "SELECT * FROM clientes WHERE id=".$id." AND baja=0";
		return $this->db->query($sql);
	}

	
}

?>