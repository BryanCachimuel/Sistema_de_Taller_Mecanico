<?php  
/**
 * 
 */
class ClientesModelo
{
	private $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function alta(array $data=[]):bool
	{
		$sql = "INSERT INTO clientes VALUES(0,";//1. id 
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
		$sql = "UPDATE clientes SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
		$salida = $this->db->queryNoSelect($sql);
		return $salida;
	}

	public function getId(string $id=''):array
	{
		if(empty($id)) return [];
		$sql = "SELECT id, nombres, apellidos, telefono, ";
		$sql.= "correo, clave, razonSocial, rfc, direccion, estado ";
		$sql.= "FROM clientes ";
		$sql.= "WHERE id='".$id."' AND baja=0";
		return $this->db->query($sql);
	}

	public function getNumRegistros():int
	{
		$sql = "SELECT COUNT(*) FROM clientes WHERE baja=0";
		$salida = $this->db->query($sql);
		return $salida["COUNT(*)"];
	}

	public function getTabla(int $inicio=1, int $tamano=0):array
	{
		$sql = "SELECT c.id, CONCAT(c.apellidos,', ',c.nombres) as nombre, ";
		$sql.= "c.razonSocial, ec.estado ";
		$sql.= "FROM clientes as c, estadoCliente as ec ";
		$sql.= "WHERE c.baja=0 AND ";
		$sql.= "c.estado=ec.id ";
		if ($tamano>0) {
			$sql.= " LIMIT ".$inicio.", ".$tamano;
		}
		return $this->db->querySelect($sql);
	}

	public function getEstadoCliente()
	{
		//
		$sql = "SELECT id, estado FROM estadoCLiente";
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
		    $sql = "UPDATE clientes SET "; 
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