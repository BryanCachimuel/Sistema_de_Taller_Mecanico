<?php  

class Clientes extends Controlador {

	private $usuario = "";
    private $modelo = "";
	private $sesion;
	
	function __construct() {
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("ClientesModelo");
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
			"titulo" => "Clientes del taller",
			"subtitulo" => "Clientes del taller",
			"usuario"=>$this->usuario,
			"data"=> $data,
			"activo" => "clientes",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "clientes",
				"pagina" => $pagina
			],
			"menu" => true
		];
		$this->vista("clientesCaratulaVista",$datos);
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
							"Modificar el mecanicos", 
							"Modificar el mecanicos", 
							"Se modificó correctamente el mecanicos: ".$nombres." ".$apellidos,
							"mecanicos/".$pagina, 
							"success"
						);
				} else {
					$this->mensaje(
						"Error al modificar el mecanicos.", 
						"Error al modificar el mecanicos.", 
						"Error al modificar el mecanicos: ".$nombres." ".$apellidos, 
						"mecanicos/".$pagina, 
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
		$tipoMecanico = $this->modelo->getTipoMecanico();
	    $estadoMecanico = $this->modelo->getEstadoMecanico();
		$datos = [
			"titulo" => "Baja de un mecánico",
			"subtitulo" => "Baja de un mecánico",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"errores"=>[],
			"data"=>$data,
			"activo" => "mecanicos",
			"pagina"=>$pagina,
			"tipoMecanico" => $tipoMecanico,
		    "estadoMecanico" => $estadoMecanico,
			"baja"=>true,
		];
		$this->vista("mecanicosAltaVista",$datos);
	}

	public function bajaLogica(string $id='', string $pagina="1"):void {
		if(isset($id) && $id!="") {
			if($this->modelo->bajaLogica($id)) {
				$this->mensaje(
					"Baja de un mecánico",
					"Baja de un mecánico",
					"Se borró correctamente al mecánico: ".$id,
					"mecanicos/".$pagina,
					"success"
				);
			} else {
				$this->mensaje(
					"Baja de un mecánico",
					"Baja de un mecánico",
					"Error al borrar al mecánico: ".$id,
					"mecanicos/".$pagina,
					"danger"
				);
			}
			
		}
	}

	public function modificar(string $id, string $pagina="1"):void {
		// leer los datos de tabla
		$data = $this->modelo->getId($id);
		$tipoMecanico = $this->modelo->getTipoMecanico();
	    $estadoMecanico = $this->modelo->getEstadoMecanico();
		$datos = [
			"titulo" => "Modificar un mecánico",
			"subtitulo" => "Modificar un mecánico",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"activo" => "mecanicos",
			"tipoMecanico" => $tipoMecanico,
		    "estadoMecanico" => $estadoMecanico,
			"data" => $data
		];
		$this->vista("mecanicosAltaVista",$datos);
	}
	
}
?>