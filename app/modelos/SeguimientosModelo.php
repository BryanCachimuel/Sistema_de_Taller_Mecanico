<?php  
/**
 * 
 */
class SeguimientosModelo {
	
    private $db="";
	
	function __construct() {
		$this->db = new MySQLdb();
	}

	public function alta(array $data=[]):bool
	{
		$sql = "INSERT INTO seguimientos VALUES(0,";//1. id 
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
		$sql = "UPDATE seguimientos SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		$salida = $this->db->queryNoSelect($sql);
		return $salida;
	}

	public function getId(string $id=''):array {
		if(empty($id)) return [];
		$sql = "SELECT id, idVehiculo, idMecanico, fechaIngreso, fechaSalida, kilometraje, gato, herramientas, triangulos, refaccion, extintor, antena, emblemas, tapones, cables, estereo, encendedor, tapetes, estado ";
		$sql.= "FROM seguimientos ";
		$sql.= "WHERE id='".$id."' AND baja=0";
		return $this->db->query($sql);
	}

	public function getNumRegistros():int {
		$sql = "SELECT COUNT(*) FROM seguimientos WHERE baja=0";
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

	public function modificar(array $data):bool {
		$salida = false;
	    if (!empty($data["id"])) {
		    $sql = "UPDATE seguimientos SET "; 
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