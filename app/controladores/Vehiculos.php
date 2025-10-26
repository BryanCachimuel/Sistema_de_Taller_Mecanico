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
	      $nombres = Helper::cadena($_POST['nombres'] ?? "");
	      $apellidos = Helper::cadena($_POST['apellidos'] ?? "");
	      $telefono = Helper::cadena($_POST['telefono'] ?? "");
	      $correo = Helper::cadena($_POST['correo'] ?? "");
	      $direccion = Helper::cadena($_POST['direccion'] ?? "");
		  $rfc = Helper::cadena($_POST['rfc'] ?? "");
		  $razonSocial = Helper::cadena($_POST['razonSocial'] ?? "");
	      $estado = Helper::cadena($_POST['estado'] ?? "");
	      //
	      $pagina = $_POST['pagina'] ?? "1";
	      //
	      // Validamos la información
	      // 
	      if(empty($nombres)){
	        array_push($errores,"El nombre del usuario es requerido.");
	      }
	      if(empty($apellidos)){
	        array_push($errores,"Los apellidos del usuario son requeridos.");
	      }
	      if(empty($correo)){
	        array_push($errores,"El correo del usuario es requerido.");
	      }
	      if($estado=="void"){
	        array_push($errores,"El estado es obligatorio.");
	      }
	      if (Helper::correo($correo)==false) {
	      	array_push($errores,"El correo no tiene un formato válido.");
	      } else if(trim($id)==="" && $this->modelo->getCorreo($correo)){
	        array_push($errores,"El correo ya existe en la base de datos.");
	      }
	      //
	      if (empty($errores)) { 
			// Crear arreglo de datos
			//
			$data = [
				"id" => $id,
				"nombres"=>$nombres,
				"apellidos"=>$apellidos,
				"telefono"=>$telefono,
				"correo"=>$correo,
				"direccion"=>$direccion,
				"rfc"=>$rfc,
				"razonSocial"=>$razonSocial,
				"clave"=>Helper::generarClave(10),
				"estado"=>$estado
			];     
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
				if ($this->modelo->alta($data)) {
					$this->mensaje(
							"Alta de un cliente", 
							"Alta de un cliente", 
							"Se añadió correctamente al cliente: ".$nombres." ".$apellidos, 
							"clientes/".$pagina, 
							"success"
					);
		          } else {
		          	$this->mensaje(
		          		"Error al añadir el cliente.", 
		          		"Error al añadir el cliente.", 
		          		"Error al modificar el cliente: ".$nombres." ".$apellidos, 
		          		"clientes/".$pagina,
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
	    	$estadoCliente = $this->modelo->getEstadoCliente();
		    $datos = [
		      "titulo" => "Alta de un cliente",
		      "subtitulo" => "Alta de un cliente",
		      "activo" => "clientes",
		      "menu" => true,
		      "admon" => true,
		      "usuario" => $this->usuario,
		      "errores" => $errores,
		      "estadoCliente" => $estadoCliente,
		      "data" => $data
		    ];
		    $this->vista("clientesAltaVista",$datos);
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