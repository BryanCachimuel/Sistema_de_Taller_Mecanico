<?php  
/**
 * 
 */
class Mecanicos extends Controlador
{
	private $modelo = "";
	private $usuario;
	private $sesion;
	
	function __construct()
	{
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("MecanicosModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
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
	      $tipoMecanico = Helper::cadena($_POST['tipoMecanico'] ?? "");
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
	      if($tipoMecanico=="void"){
	        array_push($errores,"El tipo de mecánico es obligatorio.");
	      }
	      if (Helper::correo($correo)==false) {
	      	array_push($errores,"El correo no tiene un formato válido.");
	      } else if(trim($id)==="" && $this->modelo->getCorreo($correo)!=false){
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
				"clave"=>Helper::generarClave(10),
				"estado"=>$estado,
				"idTipoMecanico"=>$tipoMecanico
			];     
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
				if ($this->modelo->alta($data)) {
					$this->mensaje(
							"Alta de un mecánico", 
							"Alta de un mecánico", 
							"Se añadió correctamente el mecánico: ".$nombres." ".$apellidos, 
							"mecanicos/".$pagina, 
							"success"
					);
		          } else {
		          	$this->mensaje(
		          		"Error al añadir el mecánico.", 
		          		"Error al añadir el mecánico.", 
		          		"Error al modificar el mecánico: ".$nombres." ".$apellidos, 
		          		"mecanicos/".$pagina,
		          		"danger"
		          	);
		          }
	        } else {
			  //Modificar
			  if ($this->modelo->modificar($data)) {
					$this->mensaje(
							"Modificar el mecánico", 
							"Modificar el mecánico", 
							"Se modificó correctamente el mecánico: ".$nombres." ".$apellidos,
							"mecanicos/".$pagina, 
							"success"
						);
				} else {
					$this->mensaje(
						"Error al modificar el mecánico.", 
						"Error al modificar el mecánico.", 
						"Error al modificar el mecánico: ".$nombres." ".$apellidos, 
						"mecanicos/".$pagina, 
						"danger"
					);
				}
	        }
	      }
	    }
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$tipoMecanico = $this->modelo->getTipoMecanico();
	    	$estadoMecanico = $this->modelo->getEstadoMecanico();
		    $datos = [
		      "titulo" => "Alta de un mecánico",
		      "subtitulo" => "Alta de un mecánico",
		      "activo" => "mecanicos",
		      "menu" => true,
		      "admon" => true,
		      "usuario" => $this->usuario,
		      "errores" => $errores,
		      "tipoMecanico" => $tipoMecanico,
		      "estadoMecanico" => $estadoMecanico,
		      "data" => $data
		    ];
		    $this->vista("mecanicosAltaVista",$datos);
	    }
  	}

	public function borrar(string $id="",string $pagina="1"):void 
	{
		//Leemos los datos del registro del id
		$data = $this->modelo->getId($id);
		$tipoMecanico = $this->modelo->getTipoMecanico();
    	$estadoMecanico = $this->modelo->getEstadoMecanico();
		$datos = [
		  "titulo" => "Baja de un macánico",
		  "subtitulo" => "Baja de un macánico",
		  "menu" => true,
		  "admon" => true,
		  "usuario" => $this->usuario,
		  "errores" => [],
		  "activo" => 'mecanicos',
		  "data" => $data,
		  "pagina" => $pagina,
		  "tipoMecanico" => $tipoMecanico,
		  "estadoMecanico" => $estadoMecanico,
		  "baja" => true
		];
		$this->vista("mecanicosAltaVista",$datos);
	}

	public function bajaLogica(string $id='',string $pagina="1"):void
	{
		if (isset($id) && $id!="") {
			if ($this->modelo->bajaLogica($id)) {
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

	public function caratula(string $pagina="1"):void
	{
		$num = $this->modelo->getNumRegistros();
		$inicio = ($pagina-1)*TAMANO_PAGINA;
		$totalPaginas = ceil($num/TAMANO_PAGINA);
		$data = $this->modelo->getTabla($inicio,TAMANO_PAGINA);
		$datos = [
			"titulo" => "Mecánicos taller mecánico",
			"subtitulo" => "Mecánicos taller mecánico",
			"usuario"=>$this->usuario,
			"data"=>$data,
			"activo" => "mecanicos",
			"pag" => [
				"totalPaginas" => $totalPaginas,
				"regresa" => "mecanicos",
				"pagina" => $pagina
			],
			"menu" => true
		];
		$this->vista("mecanicosCaratulaVista",$datos);
	}

	public function modificar(string $id,string $pagina="1"):void
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
    	$tipoMecanico = $this->modelo->getTipoMecanico();
    	$estadoMecanico = $this->modelo->getEstadoMecanico();
		$datos = [
			"titulo" => "Modificar un mecánico",
			"subtitulo" =>"Modificar un mecánico",
			"menu" => true,
			"admon" => true,
			"usuario" => $this->usuario,
			"activo" => "mecanicos",
			"tipoMecanico" => $tipoMecanico,
			"estadoMecanico" => $estadoMecanico,
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("mecanicosAltaVista",$datos);
	}
}
?>