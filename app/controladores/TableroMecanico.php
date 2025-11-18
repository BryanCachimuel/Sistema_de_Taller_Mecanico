<?php  
/**
 * 
 */
class TableroMecanico extends Controlador
{
	protected $usuario="";
	protected $modelo = "";
	protected $sesion;
	
	function __construct()
	{
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("TableroMecanicoModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function caratula()
	{
		$datos = [
			"titulo" => "Sistema de taller mecánico",
			"subtitulo" => $this->usuario["nombres"]." ".$this->usuario["apellidos"],
			"usuario"=>$this->usuario,
			"data"=>[],
			"menu" => false
		];
		$this->vista("tableroMecanicoCaratulaVista",$datos);
	}

	public function logout()
	{
		if (isset($_SESSION['usuario'])) {
			$this->sesion->finalizarLogin();
		}
		header("location:".RUTA);
	}
}
?>