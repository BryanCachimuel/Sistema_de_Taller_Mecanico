<?php  
/**
 * 
 */
class Seguimientos extends Controlador {
	
    private $modelo = "";
	private $usuario;
	private $sesion;
	
	function __construct()
	{
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("SeguimientosModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function alta(string $idOrdenReparacion=""):void {
	   //Definir los arreglos
	    $data = array();
	    $errores = array();
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $idSeguimiento = $_POST['id'] ?? "";
	      $idOrdenReparacion = Helper::cadena($_POST['idOrdenReparacion'] ?? "");
	      $fecha = Helper::cadena($_POST['fecha'] ?? "");
	      $observacion = Helper::cadena($_POST['observacion'] ?? "");

	      $pagina = $_POST['pagina'] ?? "1";

		// validación de información
	     if(empty($fecha)){
	        array_push($errores,"La fecha del seguimiento es requerida.");
	      } 
	      if(Helper::fecha($fecha)==false){
	      	array_push($errores,"El formato de la fecha no es correcto.");
	      } 

	      //
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
				"id" => $idSeguimiento,
				"id" => $idSeguimiento,
				"idOrdenReparacion"=>$idOrdenReparacion,
				"fecha"=>$fecha,
				"observacion"=>$observacion
			];    
	         //Enviamos al modelo
	        if(trim($idSeguimiento)===""){
	          //Alta
	        	$id = $this->modelo->alta($data);
				if ($id) {
					// Imagenes
					Helper::mostrar($id);
					$this->mensaje(
							"Alta de una orden de reparación", 
							"Alta de una orden de reparación", 
							"Se añadió correctamente la orden de reparación.", 
			          		"ordenReparacion/".$pagina, 
			          		"success"
					);
		          } else {
		          	$this->mensaje(
		          		"Error al añadir la orden de reparación.", 
		          		"Error al añadir la orden de reparación.", 
		          		"Error al modificar la orden de reparación.", 
		          		"ordenreparacion/".$pagina,
		          		"danger"
		          	);
		          }
	        } else {
			  //Modificar
			  if ($this->modelo->modificar($data)) {
					$this->mensaje(
							"Modificar la orden de reparación.", 
							"Modificar la orden de reparación.", 
							"Se modificó correctamente la orden de reparación.",
							"ordenreparacion/".$pagina, 
							"success"
						);
				} else {
					$this->mensaje(
						"Error al modificar el vehículo.", 
						"Error al modificar el vehículo.", 
						"Error al modificar el vehículo: ".$marca." ".$modelo, 
						"ordenreparacion/".$pagina, 
						"danger"
					);
				}
	        }
	      }
	    }
	    if(!empty($idOrdenReparacion)){
	    	//Vista Alta
		    $datos = [
		      "titulo" => "Seguimiento de una orden de reparación",
		      "subtitulo" => "Seguimiento de una orden de reparación",
		      "activo" => "seguimientos",
		      "menu" => true,
		      "admon" => true,
		      "usuario" => $this->usuario,
		      "errores" => $errores,
			  "idOrdenReparacion" => $idOrdenReparacion,
		      "pagina" => 1,
		      "data" => $data
		    ];
		    $this->vista("seguimientosAltaVista",$datos);
	    }
  	}

	public function borrar(string $id="",string $pagina="1"):void 
	{
		//Leemos los datos del registro del id
		$data = $this->modelo->getId($id);
		$vehiculos = $this->modelo->getVehiculos();
	   	$mecanicos = $this->modelo->getMecanicos();
		$datos = [
		  "titulo" => "Baja de una orden de reparación",
		  "subtitulo" => "Baja de una orden de reparación",
		  "menu" => true,
		  "admon" => true,
		  "usuario" => $this->usuario,
		  "errores" => [],
		  "activo" => 'ordenreparacion',
		  "data" => $data,
		  "pagina" => $pagina,
		  "vehiculos" => $vehiculos,
		  "mecanicos" => $mecanicos,
		  "baja" => true
		];
		$this->vista("ordenReparacionAltaVista",$datos);
	}

	public function bajaLogica(string $id='',string $pagina="1"):void
	{
		if (isset($id) && $id!="") {
			if ($this->modelo->bajaLogica($id)) {
				$this->mensaje(
					"Baja de una orden de reparación", 
					"Baja de una orden de reparación", 
					"Se borró correctamente la orden de reparación: ".$id, 
					"ordenreparacion/".$pagina, 
					"success"
				);
	        } else {
	        	$this->mensaje(
	        		"Baja de una orden de reparación", 
	        		"Baja de una orden de reparación", 
	        		"Error al borrar la orden de reparación: ".$id, 
	        		"ordenreparacion/".$pagina,
	        		"danger"
	        	);
	        }
	   }
	}

	public function caratula(string $pagina="1"):void
	{
		$num = $this->modelo->getNumRegistros("ordenreparacion");
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTablaOrdenReparacion($inicio,TAMANO_PAGINA);
		$datos = [
			"titulo" => "Seguimientos",
			"subtitulo" => "Seguimientos",
			"usuario"=>$this->usuario,
			"data"=>$data,
			"activo" => "seguimientos",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "seguimientos",
				"pagina" => $pagina
			],
			"menu" => true
		];
		$this->vista("seguimientosCaratulaVista",$datos);
	}

	public function modificar(string $id,string $pagina="1"):void
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
		$vehiculos = $this->modelo->getVehiculos();
	    $mecanicos = $this->modelo->getMecanicos();
		$datos = [
			"titulo" => "Modificar una orden de reparación",
			"subtitulo" =>"Modificar una orden de reparación",
			"menu" => true,
			"admon" => true,
			"usuario" => $this->usuario,
			"activo" => "ordenreparacion",
			"vehiculos" => $vehiculos,
		     "mecanicos" => $mecanicos,
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("ordenReparacionAltaVista",$datos);
	}

	public function mostrar(string $id,string $pagina="1"):void {
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
		$vehiculos = $this->modelo->getVehiculos();
	    $mecanicos = $this->modelo->getMecanicos();
		$piezas = $this->modelo->getPiezas($id);
		$datos = [
			"titulo" => "Mostrar una orden de reparación",
			"subtitulo" =>"Mostrar una orden de reparación",
			"menu" => true,
			"admon" => true,
			"usuario" => $this->usuario,
			"activo" => "ordenreparacion",
			"vehiculos" => $vehiculos,
		    "mecanicos" => $mecanicos,
			"piezas" => $piezas,
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("ordenReparacionMostrarVista",$datos);
	}

    public function seguimiento(string $idOrdenReparacion, string $pagina="1"):void {
        $num = $this->modelo->getNumRegistros("seguimientos");
        $inicio = ($pagina-1)*TAMANO_PAGINA;
        $totalPaginas = ceil($num/TAMANO_PAGINA);
        $data = $this->modelo->getTablaSeguimiento($inicio,TAMANO_PAGINA,$idOrdenReparacion);
        $datos = [
            "titulo" => "Seguimiento a una orden de reparación",
            "subtitulo" => "Seguimiento a una orden de reparación",
            "usuario" => $this->usuario,
            "activo" => "seguimientos",
            "admon" => true,
            "data" => $data,
            "idOrdenReparacion" => $idOrdenReparacion,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "seguimientos",
                "pagina" => $pagina
            ],
            "menu" => true
        ];
        $this->vista("seguimientosOrdenReparacionCaratulaVista",$datos);
    }

}
?>