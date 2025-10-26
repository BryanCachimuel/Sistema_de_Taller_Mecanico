<?php  

class Vehiculos extends Controlador {

	private $usuario = "";
    private $modelo = "";
	private $sesion;
	
	function __construct() {
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("VehiculosModelo");
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
			"titulo" => "Vehículos",
			"subtitulo" => "Vehículos",
			"usuario"=>$this->usuario,
			"data"=> $data,
			"activo" => "vehiculos",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "vehiculos",
				"pagina" => $pagina
			],
			"menu" => true
		];
		$this->vista("vehiculosCaratulaVista",$datos);
	}

	public function alta(){
	   //Definir los arreglos
	    $data = array();
	    $errores = array();
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $id = $_POST['id'] ?? "";
	      $marca = Helper::cadena($_POST['marca'] ?? "");
	      $modelo = Helper::cadena($_POST['modelo'] ?? "");
	      $color = Helper::cadena($_POST['color'] ?? "");
	      $anio = Helper::numero(Helper::cadena($_POST['anio'] ?? ""));
	      $placas = Helper::cadena($_POST['placas'] ?? "");
	      $idCliente = Helper::cadena($_POST['idCliente'] ?? "");
	      //
	      $pagina = $_POST['pagina'] ?? "1";
	      //
	      // Validamos la información
	      // 
	      if(empty($marca)){
	        array_push($errores,"La marca del vehículo es requerida.");
	      }
	      if(empty($modelo)){
	        array_push($errores,"El modelo del vehículo es requeridos.");
	      }
		  if($idCliente=="void"){
	        array_push($errores,"El color del vehículo es obligatorio.");
	      }
	      if(empty($anio)){
	        array_push($errores,"El año del vehículo es requerido.");
	      }
		  if(empty($placas)){
	        array_push($errores,"La placa del vehículo es requerida.");
	      }
	      if($idCliente=="void"){
	        array_push($errores,"El cliente es obligatorio.");
	      }
	      //
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
				"id" => $id,
				"marca"=>$marca,
				"modelo"=>$modelo,
				"anio"=>$anio,
				"color"=>$color,
				"placas"=>$placas,
				"idCliente"=>$idCliente
			];     
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
				if ($this->modelo->alta($data)) {
					$this->mensaje(
							"Alta de un vehículo", 
							"Alta de un vehículo", 
							"Se añadió correctamente el vehículo: ".$marca." ".$modelo, 
							"vehiculos/".$pagina, 
							"success"
					);
		          } else {
		          	$this->mensaje(
		          		"Error al añadir el vehículo.", 
		          		"Error al añadir el vehículo.", 
		          		"Error al modificar el vehículo: ".$marca." ".$modelo, 
		          		"vehiculos/".$pagina,
		          		"danger"
		          	);
		          }
	        } else {
			  //Modificar
			  if ($this->modelo->modificar($data)) {
					$this->mensaje(
							"Modificar el cliente", 
							"Modificar el cliente", 
							"Se modificó correctamente el cliente: ".$nombres." ".$apellidos,
							"clientes/".$pagina, 
							"success"
						);
				} else {
					$this->mensaje(
						"Error al modificar el cliente.", 
						"Error al modificar el cliente.", 
						"Error al modificar el cliente: ".$nombres." ".$apellidos, 
						"clientes/".$pagina, 
						"danger"
					);
				}
	        }
	      }
	    }
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$clientes = $this->modelo->getClientes();
		    $datos = [
		      "titulo" => "Alta de un vehículo",
		      "subtitulo" => "Alta de un vehículo",
		      "activo" => "vehiculos",
		      "menu" => true,
		      "admon" => true,
		      "usuario" => $this->usuario,
		      "errores" => $errores,
		      "clientes" => $clientes,
		      "data" => $data
		    ];
		    $this->vista("vehiculosAltaVista",$datos);
	    }
  	}


	public function borrar(string $id="", string $pagina="1"):void {
		// leer datos del registro del id
		$data = $this->modelo->getId($id);
		$estadoCliente = $this->modelo->getEstadoCliente();
		$datos = [
			"titulo" => "Baja de un cliente",
			"subtitulo" => "Baja de un cliente",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"errores"=>[],
			"data"=>$data,
			"activo" => "clientes",
			"pagina"=>$pagina,
		    "estadoCliente" => $estadoCliente,
			"baja"=>true,
		];
		$this->vista("clientesAltaVista",$datos);
	}

	public function bajaLogica(string $id='', string $pagina="1"):void {
		if(isset($id) && $id!="") {
			if($this->modelo->bajaLogica($id)) {
				$this->mensaje(
					"Baja de un cliente",
					"Baja de un cliente",
					"Se borró correctamente al cliente: ".$id,
					"clientes/".$pagina,
					"success"
				);
			} else {
				$this->mensaje(
					"Baja de un cliente",
					"Baja de un cliente",
					"Error al borrar al cliente: ".$id,
					"clientes/".$pagina,
					"danger"
				);
			}
			
		}
	}

	public function modificar(string $id, string $pagina="1"):void {
		// leer los datos de tabla
		$data = $this->modelo->getId($id);
		$estadoCliente = $this->modelo->getEstadoCliente();
		$datos = [
			"titulo" => "Modificar un cliente",
			"subtitulo" => "Modificar un cliente",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"activo" => "clientes",
		    "estadoCliente" => $estadoCliente,
			"data" => $data
		];
		$this->vista("clientesAltaVista",$datos);
	}
	
}
?>