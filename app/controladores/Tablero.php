<?php  
/**
 * 
 */
class Tablero extends Controlador
{
	protected $usuario = "";
	protected $modelo = "";
	protected $sesion;
	
	function __construct() {
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("TableroModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function caratula() {
		$datos = [
			"titulo" => "Sistema de taller mecánico",
			"subtitulo" => $this->usuario["nombres"]." ".$this->usuario["apellidos"],
			"usuario"=>$this->usuario,
			"data"=>[],
			"menu" => true
		];
		$this->vista("tableroCaratulaVista",$datos);
	}

	public function logout() {
		if (isset($_SESSION['usuario'])) {
			$this->sesion->finalizarLogin();
		}
		header("location:".RUTA);
	}

	public function respaldar() {
		$m = "Cuidado: Este proceso realiza el respaldo de la base de datos. Puede tardar algunos minutos.";
    	$this->mensaje(
	  		"Respaldar la base de datos", 
	  		"Respaldar la base de datos", 
	  		$m, 
	  		"tablero",
	  		"danger",
	  		"tablero/respaldarEjecutar/",
	  		"success",
	  		"Respaldar"
	  	);
	}

	public function respaldarEjecutar() {
		$fecha = date("Ymdhis");
		$id = uniqid();
		$tablas = $this->modelo->getTablas();
		foreach ($tablas as $tabla) {
			$this->modelo->respaldarTabla($tabla["Tables_in_taller"],$fecha,$id);
		}
		$this->mensaje(
			"Respaldo de base de datos",
			"Respaldo de base de datos",
			"El respaldo de base de datos fue exitosa.<br>En la carpeta:<br>respaldos/".$fecha."-".$id,
			"tablero",
			"success"
		);
	}


}
?>