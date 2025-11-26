<?php  
/**
 * 
 */
class LoginModelo
{
	private $db="";
	
	function __construct()
	{
		$this->db = new MySQLdb();
	}

	public function actualizarClaveAcceso(array $data=[]):bool
	{
		if (!empty($data)) {
			$sql = "UPDATE usuarios SET clave=:clave, estadoUsuario=:estadoUsuario WHERE id=:id";
			return $this->db->queryNoSelect($sql,$data);
		}
		return false;
	}

	public function actualizarLogin(string $id='',string $tabla):bool
	{
		if (!empty($data)) {
			$sql = "UPDATE ".$tabla." SET login_dt=(NOW()) WHERE id=".$id;
			return $this->db->queryNoSelect($sql);
		}
		return false;
	}

	public function buscarCorreo(string $correo=''):array
	{
		if($correo=="") return [];
	 	$sql = "SELECT id, tipoUsuario, nombres, apellidos, direccion, ";
	 	$sql.= "telefono, correo, clave, genero, estadoUsuario ";
	 	$sql.= "FROM usuarios ";
	 	$sql.= "WHERE correo = '".$correo."' AND baja=0";
	 	return $this->db->query($sql);
	}

	public function buscarCorreoMecanico(string $correo=''):array
	{
		if($correo=="") return [];
	 	$sql = "SELECT id, nombres, apellidos, correo, clave, telefono, idTipoMecanico, estado ";
	 	$sql.= "FROM mecanicos ";
	 	$sql.= "WHERE correo = '".$correo."' AND baja=0";
	 	return $this->db->query($sql);
	}

	public function buscarCorreoCliente(string $correo=''):array
	{
		if($correo=="") return [];
	 	$sql = "SELECT id, nombres, apellidos, razonSocial, direccion, telefono, rfc, correo, clave, estado ";
	 	$sql.= "FROM clientes ";
	 	$sql.= "WHERE correo = '".$correo."' AND baja=0";
	 	return $this->db->query($sql);
	}
}

?>