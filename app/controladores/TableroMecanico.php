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

	public function caratula(string $pagina="1") {
		$num = $this->modelo->getNumRegistros("ordenReparacion",$this->usuario["id"]);
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTablaOrdenReparacion($inicio,TAMANO_PAGINA,$this->usuario["id"]);
		$datos = [
			"titulo" => "Órdenes de reparación",
			"subtitulo" => "Órdenes de reparación",
			"usuario"=>$this->usuario,
			"data"=>$data,
			"activo" => "salidas",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "salidas",
				"pagina" => $pagina
			],
			"menu" => false
		];
		$this->vista("tableroMecanicoCaratulaVista",$datos);
	}


	public function logout() {
		if (isset($_SESSION['usuario'])) {
			$this->sesion->finalizarLogin();
		}
		header("location:".RUTA);
	}

	public function mostrar(string $id,string $pagina="1"):void {
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
	    $piezas = $this->modelo->getPiezas($id);
		$datos = [
			"titulo" => "Mostrar una orden de reparación",
			"subtitulo" =>"Mostrar una orden de reparación",
			"menu" => false,
			"admon" => false,
			"usuario" => $this->usuario,
			"activo" => "tableroMecanico",
		    "piezas" => $piezas,
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("tableroMecanicoMostrarVista",$datos);
	}

}
?>