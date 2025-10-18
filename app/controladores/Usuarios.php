<?php  

class Usuarios extends Controlador {

	private $usuario = "";
    private $modelo = "";
	private $sesion;
	
	function __construct() {
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("UsuariosModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function alta() {
		// definir los arreglos
		$data = array();
		$errores = array();
		if(!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
			// vista alta
			$tipoUsuarios = $this->modelo->getTipoUsuarios();
			$generos = $this->modelo->getGeneros();
			$estadoUsuarios = $this->modelo->getEstadosUsuarios();
			$datos = [
				"titulo" => "Alta de un usuario",
				"subtitulo" => "Alta de un usuario",
				"activo" => "usuarios",
				"usuario"=>$this->usuario,
				"menu" => true,
				"admon" => true,
				"tipoUsuarios" => $tipoUsuarios,
				"estadosUsuarios" => $estadoUsuarios,
				"generos" => $generos,
				"data" => $data
			];
			Helper::mostrar($datos);
			$this->vista("usuariosAltaVista",$datos);
		}
	}

	public function caratula() {
        $data = $this->modelo->getTabla();
 		$datos = [
			"titulo" => "Usuarios taller mecánico",
			"subtitulo" => "Usuarios taller mecánico",
			"usuario"=>$this->usuario,
			"data"=> $data,
			"activo" => "usuarios",
			"pag" => [
				"pagina" => 1
			],
			"menu" => true
		];
		$this->vista("usuariosCaratulaVista",$datos);
	}

	
}
?>