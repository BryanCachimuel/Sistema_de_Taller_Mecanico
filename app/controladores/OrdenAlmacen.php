<?php  

class OrdenAlmacen extends Controlador {

	private $usuario = "";
    private $modelo = "";
	private $sesion;
	
	function __construct() {
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("OrdenAlmacenModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	
	public function caratula(string $pagina="1"):void {
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
        $data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);
 		$datos = [
			"titulo" => "Orden de Almacén",
			"subtitulo" => "Orden de Almacén",
			"usuario"=>$this->usuario,
			"data"=> $data,
			"activo" => "ordenalmacen",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "ordenalmacen",
				"pagina" => $pagina
			],
			"menu" => true
		];
		$this->vista("OrdenAlmacenCaratulaVista",$datos);
	}

	public function alta(){
	   //Definir los arreglos
	    $data = array();
	    $errores = array();
	    
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$ordenesReparacion = $this->modelo->getOrdenesReparacion();
		    $datos = [
		      "titulo" => "Alta de una Orden de Almacén",
		      "subtitulo" => "Alta de una Orden de Almacén",
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

    public function altaOrdenAlmacenDetalle():void {
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
					//exit;
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

	public function anadirPieza(string $idOrdenAlmacen, string $idOrdenReparacion, array $data, array $piezas, array $errores):void {
		$datos = [
			"titulo" => "Detalle de una Orden de Almacén",
			"subtitulo" => "Detalle de una Orden de Almacén",
			"activo" => "ordenalmacen",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"errores"=>$errores,	
		    "idOrdenReparacion" => $idOrdenReparacion,
			"idOrdenAlmacen" => $idOrdenAlmacen, 
			"piezas" => $piezas,
			"pag"=>1,
			"data"=>$data,
		];
		$this->vista("ordenAlmacenAltaPiezaVista",$datos);
	}

	public function altaOrdenAlmacenPieza():void {
		//Llamada desde: ordenAlmacenAltaVista
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
			if ($cantidad>$pieza["stock"]) {
				array_push($errores,"No hay suficiente stock de esa pieza.");
			}
			if (empty($errores)) {
				$data["costo"] = $cantidad * $pieza["costo"];
				if ($this->modelo->altaOrdenAlmacenDetalle($data,$pieza)) {
					Helper::mostrar($data);
				    //$this->mostrarOrdenAlmacen($idOrdenAlmacen,$data,$errores);
				} else {
					$this->mensaje(
						"Error al crear el detalle de la orden de almacén.", 
						"Error al crear el detalle de la orden de almacén.", 
						"Error al crear el detalle de la orden de almacén: ".$pieza["nombrePieza"], 
						"ordenAlmacen/".$pag, 
						"danger"
					);
				}
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


	public function borrar(string $id="", string $pagina="1"):void {
		// leer datos del registro del id
		$data = $this->modelo->getId($id);
		$vehiculos = $this->modelo->getVehiculos();
	    $mecanicos = $this->modelo->getMecanicos();
		$datos = [
			"titulo" => "Baja de una Orden de Reparación",
			"subtitulo" => "Baja de una Ordeb de Reparación",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"errores"=>[],
			"data"=>$data,
			"activo" => "ordenreparacion",
			"pagina"=>$pagina,
		    "vehiculos" => $vehiculos,
			"mecanicos" => $mecanicos, 
			"baja"=>true,
		];
		$this->vista("ordenReparacionAltaVista",$datos);
	}

	public function bajaLogica(string $id='', string $pagina="1"):void {
		if(isset($id) && $id!="") {
			if($this->modelo->bajaLogica($id)) {
				$this->mensaje(
					"Baja de una Orden de Reparación",
					"Baja de una Orden de Reparación",
					"Se borró correctamente una Orden de Reparación: ".$id,
					"ordenreparacion/".$pagina,
					"success"
				);
			} else {
				$this->mensaje(
					"Baja de una Orden de Reparación",
					"Baja de una Orden de Reparación",
					"Error al borrar una Orden de Reparación: ".$id,
					"ordenreparacion/".$pagina,
					"danger"
				);
			}
			
		}
	}

	public function modificar(string $id, string $pagina="1"):void {
		// leer los datos de tabla
		$data = $this->modelo->getId($id);
		$vehiculos = $this->modelo->getVehiculos();
	    $mecanicos = $this->modelo->getMecanicos();
		$datos = [
			"titulo" => "Modificar una Orden de Reparación",
			"subtitulo" => "Modificar una Orden de Reparación",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"activo" => "ordenrepacion",
		    "vehiculos" => $vehiculos,
			"mecanicos" => $mecanicos, 
			"data" => $data
		];
		$this->vista("ordenReparacionAltaVista",$datos);
	}

	public function mostrar(string $id, string $pagina="1"):void {
		// leer los datos de tabla
		$data = $this->modelo->getId($id);
		$vehiculos = $this->modelo->getVehiculos();
	    $mecanicos = $this->modelo->getMecanicos();
		$datos = [
			"titulo" => "Mostrar una Orden de Reparación",
			"subtitulo" => "Mostrar una Orden de Reparación",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"activo" => "ordenrepacion",
		    "vehiculos" => $vehiculos,
			"mecanicos" => $mecanicos, 
			"data" => $data
		];
		$this->vista("ordenReparacionMostrarVista",$datos);
	}
	
}
?>