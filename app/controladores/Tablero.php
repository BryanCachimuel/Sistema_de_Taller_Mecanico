<?php  
/**
 * 
 */
class Tablero extends Controlador
{
	private $usuario = "";
    private $modelo = "";
	private $sesion;
	
	function __construct()
	{
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("TableroModelo");
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
			"menu" => true
		];
		$this->vista("tableroCaratulaVista",$datos);
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