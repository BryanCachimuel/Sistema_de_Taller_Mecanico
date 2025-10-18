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

	public function caratula() {
        $data = $this->modelo->getTabla();
 		$datos = [
			"titulo" => "Usuarios taller mecánico",
			"subtitulo" => "Usuarios taller mecánico",
			"usuario"=>$this->usuario,
			"data"=> $data,
			"pag" => [
				"pagina" => 1
			],
			"menu" => true
		];
		$this->vista("usuariosCaratulaVista",$datos);
	}

	
}
?>