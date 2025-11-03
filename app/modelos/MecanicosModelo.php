<?php  
/**
 * 
 */
class MecanicosModelo
{
	private $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta(array $data=[]):bool
	{
		$sql = "INSERT INTO mecanicos VALUES(0,"; //1. id 
		$sql.= "'".$data['nombres']."', "; 		//2. nombre
		$sql.= "'".$data['apellidos']."', "; 	//3. apellidos
		$sql.= "'".$data['correo']."', "; 		//4. correo
		$sql.= "'".$data['clave']."', "; 		//5. clave
		$sql.= "'".$data['telefono']."', "; 	//6. telefono
		$sql.= "'".$data['idTipoMecanico']."', "; //7. genero
		$sql.= "'".$data['estado']."', ";//8. estadoUsuario
		//
		$sql.= "0, ";                   //9. baja
		$sql.= "'', ";                  //10. fecha login
		$sql.= "NOW(), ";               //11. fecha alta
		$sql.= "'', ";                  //12. fecha baja 
		$sql.= "'')";                   //13. fecha cambio
		return $this->db->queryNoSelect($sql);
	}

	public function bajaLogica(string $id):bool
	{
		$salida = false;
		$sql = "UPDATE mecanicos SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		$salida = $this->db->queryNoSelect($sql);
		return $salida;
	}

	public function getId(string $id=''):array
	{
		if(empty($id)) return [];
		$sql = "SELECT id, nombres, apellidos, telefono, ";
		$sql.= "correo, clave, idTipoMecanico, estado FROM mecanicos ";
		$sql.= "WHERE id='".$id."' AND baja=0";
		return $this->db->query($sql);
	}

	public function getNumRegistros():int
	{
		$sql = "SELECT COUNT(*) FROM mecanicos WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTabla(int $inicio=1, int $tamano=0):array
	{
		$sql = "SELECT m.id, CONCAT(m.apellidos,', ',m.nombres) as nombre, ";
		$sql.= "tm.tipo, em.estado ";
		$sql.= "FROM mecanicos as m, tipoMecanico as tm, estadoMecanico as em ";
		$sql.= "WHERE m.baja=0 AND ";
		$sql.= "m.estado=em.id AND ";
		$sql.= "m.idTipoMecanico=tm.id";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

	public function getTipoMecanico()
	{
		//
		$sql = "SELECT id, tipo FROM tipoMecanico";
		return $this->db->querySelect($sql);
	}

	public function getEstadoMecanico()
	{
		//
		$sql = "SELECT id, estado FROM estadoMecanico";
		return $this->db->querySelect($sql);
	}

	public function getCorreo(string $correo=""):array
	{
		//
		$sql = "SELECT id FROM mecanicos WHERE correo='".$correo."' AND baja=0";
		return $this->db->query($sql);
	}

	public function modificar(array $data):bool
	{
		$salida = false;
	    if (!empty($data["id"])) {
		    $sql = "UPDATE mecanicos SET "; 
			$sql.= "nombres='".$data['nombres']."', ";
			$sql.= "apellidos='".$data['apellidos']."', ";
			$sql.= "telefono='".$data['telefono']."', ";
			$sql.= "correo='".$data['correo']."', ";
			$sql.= "estado='".$data['estado']."', ";
			$sql.= "idTipoMecanico='".$data['idTipoMecanico']."', ";
			$sql.= "cambio_dt=(NOW()) ";
			$sql.= "WHERE id=".$data['id'];
		    //Enviamos a la base de datos
		    $salida = $this->db->queryNoSelect($sql);
	    }
	    return $salida;
	}
}

?>