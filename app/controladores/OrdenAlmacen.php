<?php  
/**
 * 
 */
class OrdenAlmacen extends Controlador
{
	private $modelo = "";
	private $usuario;
	private $sesion;
	
	function __construct()
	{
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("OrdenAlmacenModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function alta(){
	   //Definir los arreglos
	    $data = array();
	    $errores = array();
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$ordenesReparacion = $this->modelo->getOrdenesReparacion();
		    $datos = [
		      "titulo" => "Alta de una orden de almacén",
		      "subtitulo" => "Alta de una orden de almacén",
		      "activo" => "ordenalmacen",
		      "menu" => true,
		      "admon" => true,
		      "usuario" => $this->usuario,
		      "errores" => $errores,
			  "ordenesReparacion" => $ordenesReparacion,
		      "pagina" => 1,
		      "data" => $data
		    ];
		    $this->vista("ordenAlmacenAltaVista",$datos);
	    }
  	}

  	public function altaOrdenAlmacenDetalle():void
  	{
  		//Llamada desde: ordenAlmacenAltaVista
		//Definir los arreglos
	    $data = array();
	    $errores = array();
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	    	$idOrdenReparacion = $_POST['idOrdenReparacion'] ?? "";
			$observacion = Helper::cadena($_POST['observacion'] ?? "");
			$pag = Helper::cadena($_POST['pag'] ?? "1");
			//
			$idOrdenAlmacen = $this->modelo->altaOrdenAlmacen($idOrdenReparacion,$observacion);
			if ($idOrdenAlmacen) {
				$piezas = $this->modelo->getPiezas();
				if (empty($piezas)) {
					$this->mensaje(
						"No hay piezas en el almacén.", 
						"No hay piezas en el almacén.", 
						"No hay piezas en el almacén para la órden de reparación: ".$idOrdenReparacion, 
						"ordenAlmacen", 
						"danger"
					);
				} else {
					$this->anadirPieza($idOrdenAlmacen,$idOrdenReparacion,$data,$piezas,$errores);
					exit;
				}
			} else {
				$this->mensaje(
					"Error al crear la orden de almacén.", 
					"Error al crear la orden de almacén.", 
					"Error al crear la orden de almacén: ".$idOrdenAlmacen, 
					"ordenAlmacen/".$pagina, 
					"danger"
				);
			}
	    }
  	}

  	public function anadirPieza(
  		string $idOrdenAlmacen,
  		string $idOrdenReparacion,
  		array $data,
  		array $piezas,
  		array $errores):void
  	{
  		$datos = [
			"titulo" => "Detalle de una orden de almacén",
			"subtitulo" => "Detalle de una orden de almacén",
			"activo" => "ordenalmacen",
			"menu" => true,
			"admon" => true,
			"errores" => $errores,
			"piezas" => $piezas,
			"idOrdenReparacion" => $idOrdenReparacion,
			"idOrdenAlmacen" => $idOrdenAlmacen,
			"pag"=>1,
			"data" => $data
	    ];
	    $this->vista("ordenAlmacenAltaPiezaVista",$datos);
  	}

  	public function altaOrdenAlmacenPieza():void
  	{
		//Definir los arreglos
	    $data = array();
	    $errores = array();
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	    	//
	    	$idOrdenAlmacen = $_POST['idOrdenAlmacen'] ?? "";
			$idPieza = Helper::cadena($_POST['idPieza'] ?? "");
			$cantidad = Helper::cadena($_POST['cantidad'] ?? "");
			$pag = Helper::cadena($_POST['pag'] ?? "1");
			//
			$pieza = $this->modelo->getPieza($idPieza);
			$data = $this->modelo->getId($idOrdenAlmacen);
			$data["idPieza"] = $idPieza;
			$data["cantidad"] = $cantidad;
			//
			if (empty($errores)) {
				if ($cantidad<=$pieza["stock"]) {
					$data["costo"] = $cantidad * $pieza["costo"];
					if (!$this->modelo->altaOrdenAlmacenDetalle($data,$pieza)) {
						$this->mensaje(
							"Error al crear el detalle de la orden de almacén.", 
							"Error al crear el detalle de la orden de almacén.", 
							"Error al crear el detalle de la orden de almacén: ".$pieza["nombrePieza"], 
							"ordenAlmacen/".$pag, 
							"danger"
						);
					}
				} else {
					array_push($errores,"No hay suficiente stock de esa pieza.");
				}
				$this->mostrarOrdenAlmacen($idOrdenAlmacen,$data,$errores);
				exit;
			} else {
				$this->mensaje(
					"Error al crear la orden de almacén.", 
					"Error al crear la orden de almacén.", 
					"Error al crear la orden de almacén: ".$idOrdenAlmacen, 
					"ordenAlmacen/".$pag, 
					"danger"
				);
			}
	    }
  	}

  	public function anadeOrdenAlmacenPieza(string $idOrdenAlmacen,string $pag):void
  	{
		//Definir los arreglos
	    $data = array();
	    $errores = array();
		//
		$data = $this->modelo->getId($idOrdenAlmacen);
		$idOrdenReparacion = $data["idOrdenReparacion"];
		$piezas = $this->modelo->getPiezas();
		$this->anadirPieza($idOrdenAlmacen,$idOrdenReparacion,$data,$piezas,$errores);
  	}

	public function borrar(string $idOrdenAlmacen="",string $pagina="1"):void 
	{
		//Leemos los datos del registro del id
		$data = $this->modelo->getId($idOrdenAlmacen);
		$detalle = $this->modelo->getOrdenAlmacenDetalle($idOrdenAlmacen);
		$datos = [
		  "titulo" => "Baja de una orden de almacén",
		  "subtitulo" => "Baja de una orden de almacén",
		  "menu" => true,
		  "admon" => true,
		  "usuario" => $this->usuario,
		  "errores" => [],
		  "activo" => 'ordenalmacen',
		  "data" => $data,
		  "detalle" => $detalle,
		  "pag" => $pagina,
		  "baja" => true
		];
		$this->vista("ordenAlmacenDesplegarVista",$datos);
	}

	public function bajaLogica(string $id='',string $pagina="1"):void
	{
		if (isset($id) && $id!="") {
			if ($this->modelo->bajaLogica($id)) {
				$detalle = $this->modelo->getOrdenAlmacenDetalle($id);
				if ($this->modelo->borrarPiezasOrdenAlmacen($id)){
					for ($i=0; $i < count($detalle); $i++) { 
						if (!$this->modelo->regresarPiezasOrdenAlmacen($detalle[$i]["idPieza"],$detalle[$i]["cantidad"])){
							$this->mensaje(
							"Baja de una orden de almacén", 
							"Baja de una orden de almacén", 
							"Error al borrar la orden de almacén: ".$id, 
							"ordenalmacen/".$pagina, 
							"success");
						}
					}
					$this->mensaje(
					"Baja de una orden de almacén", 
					"Baja de una orden de almacén", 
					"Se borró correctamente la orden de almacén: ".$id, 
					"ordenalmacen/".$pagina,
					"success");
				} else {
					$this->mensaje(
					"Baja de una orden de reparación", 
					"Baja de una orden de reparación", 
					"Error al borrar la orden de almacén: ".$id, 
					"ordenreparacion/".$pagina,
					"danger");
				}
	        } 
	   }
	}

	public function borrarOrdenAlmacen(string $idOrdenAlmacen=''):void
	{
		if ($this->modelo->borrarPiezasOrdenAlmacen($idOrdenAlmacen)) {
			if ($this->modelo->bajaLogica($idOrdenAlmacen)) {
				$this->caratula();
			} else {
				$this->mensaje(
				"Error al borrar orden de almacén", 
				"Error al borrar orden de almacén", 
				"Error al borrar la orden de almacén: ".$idOrdenAlmacen, 
				"ordenalmacen/".$pag,
				"danger");
			}
		} else {
			$this->mensaje(
			"Error al borrar orden de almacén", 
			"Error al borrar orden de almacén", 
			"Error al borrar las piezas de orden de almacén: ".$idOrdenAlmacen, 
			"ordenalmacen/".$pag,
			"danger");
		}
	}

	public function borrarPieza(string $idPieza='',string $pag='1'):void
	{
		if($idPieza==""){
			Helper::mostrar("Error fatal :0");
		} else {
			$piezaDetalle = $this->modelo->getPiezaDetalle($idPieza);
			$datos = [
			  "titulo" => "Baja de una pieza.",
			  "subtitulo" => "Baja de una pieza.",
			  "menu" => true,
			  "admon" => true,
			  "errores" => [],
			  "activo" => 'ordenalmacen',
			  "data" => $piezaDetalle,
			  "pag" => $pag,
			  "baja" => true
			];
			$this->vista("ordenAlmacenBajaPiezaVista",$datos);
		}
	}

	public function borrarOrdenAlmacenPieza():void
	{
		//Llamada desde: ordenAlmacenBajaPiezaVista.php
		//
		//Definir los arreglos
		//
	    $data = array();
	    $errores = array();
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	    	//
	    	$idOrdenAlmacen = $_POST['idOrdenAlmacen'] ?? "";
	    	$idOrdenAlmacenDetalle = $_POST['idOrdenAlmacenDetalle'] ?? "";
			$idPieza = Helper::cadena($_POST['idPieza'] ?? "");
			$pieza = Helper::cadena($_POST['pieza'] ?? "");
			$cantidad = Helper::cadena($_POST['cantidad'] ?? "");
			$pag = Helper::cadena($_POST['pag'] ?? "1");
			//
			if ($this->modelo->bajaPiezaLogica($idOrdenAlmacenDetalle)) {
				$this->mensaje(
				"Baja de la pieza del órden de almacén", 
				"Baja de la pieza del órden de almacén", 
				"Se borró correctamente la pieza del órden de almacén: ".$pieza, 
				"ordenalmacen/mostrarOrdenAlmacen/".$idOrdenAlmacen, 
				"success");
			} else {
				$this->mensaje(
				"Baja de una orden de almacén", 
				"Baja de una orden de almacén", 
				"Error al borrar la pieza de orden de almacén: ".$idOrdenAlmacen, 
				"ordenalmacen/".$pag,
				"danger");
			}	
		}
	}

	public function caratula(string $pagina="1"):void
	{
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);
		$datos = [
			"titulo" => "Orden de almacén",
			"subtitulo" => "Orden de almacén",
			"usuario"=>$this->usuario,
			"data"=>$data,
			"activo" => "ordenalmacen",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "ordenalmacen",
				"pagina" => $pagina
			],
			"menu" => true
		];
		$this->vista("ordenAlmacenCaratulaVista",$datos);
	}

	public function cancelarOrdenAlmacen(string $idOrdenAlmacen=''):void
	{
		$this->mensaje(
		"Cancelar la órden de almacén", 
		"Cancelar la órden de almacén", 
		"¿Desea cancelar la órden de almacén? Se borrará definitivamente del sistema.", 
		"ordenalmacen/mostrarOrdenAlmacen/".$idOrdenAlmacen, 
		"success",
		"ordenalmacen/borrarOrdenAlmacen/".$idOrdenAlmacen,
		"danger",
		"Cancelar la órden de almacén");
	}

	public function desplegarOrdenAlmacen(string $idOrdenAlmacen='', string $pag="1"):void
	{
		$data = $this->modelo->getId($idOrdenAlmacen);
		$detalle = $this->modelo->getOrdenAlmacenDetalle($idOrdenAlmacen);
		$datos = [
			"titulo" => "Detalle de una orden de almacén",
			"subtitulo" => "Detalle de una orden de almacén",
			"activo" => "ordenalmacen",
			"menu" => true,
			"admon" => true,
			"pag"=>1,
			"detalle" => $detalle,
			"data" => $data
	    ];
	    $this->vista("ordenAlmacenDesplegarVista",$datos);
	}

	public function mostrarOrdenAlmacen(
		string $idOrdenAlmacen='', 
		array $data=[], 
		array $errores=[]):void
	{
		if (empty($data)) {
			$data = $this->modelo->getId($idOrdenAlmacen);
		}
		$detalle = $this->modelo->getOrdenAlmacenDetalle($idOrdenAlmacen);
		$datos = [
			"titulo" => "Detalle de una orden de almacén",
			"subtitulo" => "Detalle de una orden de almacén",
			"activo" => "ordenalmacen",
			"menu" => true,
			"admon" => true,
			"errores" => $errores,
			"pag"=>1,
			"detalle" => $detalle,
			"data" => $data
	    ];
	    $this->vista("ordenAlmacenMostrarVista",$datos);
	}

	public function terminarOrdenAlmacen(string $idOrdenAlmacen='', string $pag="1"):void
	{
		$total = $this->modelo->calcularTotal($idOrdenAlmacen);
		if ($this->modelo->actualizarTotal($idOrdenAlmacen,$total)) {
			$detalle = $this->modelo->getOrdenAlmacenDetalle($idOrdenAlmacen);
			for ($i=0; $i < count($detalle); $i++) { 
				if (!$this->modelo->actualizarInventario($detalle[$i]["idPieza"],$detalle[$i]["cantidad"])) {
					$this->mensaje(
		          		"Error al actualizar es total en la órden de almacén.", 
		          		"Error al actualizar es total en la órden de almacén.", 
		          		"Error al actualizar es total en la órden de almacén", 
		          		"ordenAlmacen/".$pag,
		          		"danger"
		          	);
				}
			}
			$this->caratula();
			exit;
		} else {
			$this->mensaje(
          		"Error al actualizar es total en la órden de almacén.", 
          		"Error al actualizar es total en la órden de almacén.", 
          		"Error al actualizar es total en la órden de almacén", 
          		"ordenAlmacen/".$pag,
          		"danger"
          	);
		}
	}
}
?>