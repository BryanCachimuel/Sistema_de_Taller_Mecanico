<?php  
/**
 * 
 */
class Sesion
{
	private $login = false;
	private $usuario;
	
	function __construct()
	{
		@session_start();
		if (isset($_SESSION['usuario'])) {
			$this->usuario = $_SESSION['usuario'];
			$this->login = true;
		} else {
			unset($this->usuario);
			$this->login = false;
		}
	}

	public function iniciarLogin(array $usuario=[]):void
	{
		if ($usuario) {
			$this->usuario = $_SESSION['usuario'] = $usuario;
			$this->login = true;
		}
	}

	public function finalizarLogin():void
	{
		unset($this->usuario);
		unset($_SESSION['usuario']);
		$this->login = false;
	}

	public function getLogin():bool
	{
		return $this->login;
	}

	public function getUsuario():array
	{
		return $this->usuario;
	}

	public function setUsuario(array $data=[]):void
	{
		$this->usuario=$_SESSION['usuario']=$data;
	}
}
?>