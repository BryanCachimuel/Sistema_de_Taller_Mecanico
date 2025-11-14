<?php  
/**
 * 
 */
class SalidasModelo {
	private $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function altaFactura($data, $manoObra, $otro, $materiales, $iva, $total,  $observacion):int {
		$salida = 0;
		$sql = "INSERT INTO facturas VALUES(0,";//1. id 
		$sql.= "'".$data['idCliente']."', ";	//2. idCliente
		$sql.= "'".$data['id']."', "; 			//3. idOrdenReparacion
		$sql.= "'".$manoObra."', "; 			//4. manoObra
		$sql.= "'".$materiales."', "; 			//5. materiales
		$sql.= "'".$otro."', "; 				//6. otro
		$sql.= "'".$iva."', "; 					//7. iva
		$sql.= "'".$total."', "; 				//8. total
		$sql.= "'".$observacion."', "; 			//9. observacion
		//
		$sql.= "0, ";                   //10. baja
		$sql.= "NOW(), ";               //11. fecha alta
		$sql.= "'', ";                  //12. fecha baja 
		$sql.= "'')";                   //13. fecha cambio
		if($this->db->queryNoSelect($sql)){
			$salida = $this->db->query("SELECT LAST_INSERT_ID()");
			$salida = $salida["LAST_INSERT_ID()"];
		}
	   return $salida;
	}

	public function bajaLogica(string $id):bool
	{
		$salida = false;
		$sql = "UPDATE vehiculos SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		$salida = $this->db->queryNoSelect($sql);
		return $salida;
	}

	public function getClientes():array
	{
		$sql = "SELECT id, CONCAT(nombres,' ',apellidos,', ',razonSocial) as cliente ";
		$sql.= "FROM clientes WHERE baja=0 AND estado=".CLIENTE_ACTIVO." ";
		$sql.= "ORDER BY nombres, apellidos, razonSocial";
		return $this->db->querySelect($sql);
	}


	public function getId(string $id=''):array
	{
		if(empty($id)) return [];
		$sql = "SELECT id, marca, modelo, color, ";
		$sql.= "anio, placas, idCliente ";
		$sql.= "FROM vehiculos ";
		$sql.= "WHERE id='".$id."' AND baja=0";
		return $this->db->query($sql);
	}

	public function getNumRegistros(string $tabla):int {
		$sql = "SELECT COUNT(*) FROM ".$tabla." WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTablaOrdenReparacion(int $inicio=1, int $tamano=0):array {
		$sql = "SELECT o.id, o.idVehiculo, o.fechaIngreso, o.fechaSalida,  ";
		$sql.= "CONCAT(v.marca,' ',v.modelo,' ',v.anio) as vehiculo ";
		$sql.= "FROM OrdenReparacion as o, Vehiculos as v  ";
		$sql.= "WHERE o.baja=0 AND ";
		$sql.= "o.idVehiculo=v.id ";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

    public function getOrdenReparacion(string $idOrdenReparacion=''):array {
		if(empty($idOrdenReparacion)) return [];
		$sql = "SELECT  o.id, o.fechaIngreso, o.fechaSalida, o.kilometraje, ";
		$sql.= "c.id as idCliente, c.rfc, v.id as idVehiculo, ";
		$sql.= "c.nombres, c.apellidos, c.razonsocial, c.direccion, c.correo, c.telefono,";
		$sql.= "v.marca, v.modelo, v.color, v.anio, v.placas ";
		$sql.= "FROM ordenReparacion as o, clientes as c, vehiculos as v ";
		$sql.= "WHERE o.id=".$idOrdenReparacion." AND ";
		$sql.= "o.idVehiculo=v.id AND ";
		$sql.= "v.idCliente=c.id";
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

	public function getRazonSocial():array {
		$sql = "SELECT * ";
		$sql.= "FROM configuracion ";
		$sql.= "WHERE id=1";
		return $this->db->query($sql);
	}


	public function modificar(array $data):bool
	{
		$salida = false;
	    if (!empty($data["id"])) {
		    $sql = "UPDATE vehiculos SET "; 
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