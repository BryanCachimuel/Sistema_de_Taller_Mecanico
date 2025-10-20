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
			"activo" => "usuarios",
			"pag" => [
				"pagina" => 1
			],
			"menu" => true
		];
		$this->vista("usuariosCaratulaVista",$datos);
	}

	public function alta(){
	   //Definir los arreglos
	    $data = array();
	    $errores = array();
	    if ($_SERVER['REQUEST_METHOD']=="POST") {
	      //
	      $id = $_POST['id'] ?? "";
	      $tipoUsuario = Helper::cadena($_POST['tipoUsuario'] ?? "");
	      $nombres = Helper::cadena($_POST['nombres'] ?? "");
	      $apellidos = Helper::cadena($_POST['apellidos'] ?? "");
	      $direccion = Helper::cadena($_POST['direccion'] ?? "");
	      $telefono = Helper::cadena($_POST['telefono'] ?? "");
	      $correo = Helper::cadena($_POST['correo'] ?? "");
	      $genero = Helper::cadena($_POST['genero'] ?? "");
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
	      if($genero=="void"){
	        array_push($errores,"El género es obligatorio.");
	      }
	      if($tipoUsuario=="void"){
	        array_push($errores,"El tipo de usuario es obligatorio.");
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
				"tipoUsuario"=>$tipoUsuario,
				"nombres"=>$nombres,
				"apellidos"=>$apellidos,
				"direccion"=>$direccion,
				"telefono"=>$telefono,
				"correo"=>$correo,
				"clave"=>Helper::generarClave(10),
				"genero"=>$genero,
				"estadoUsuario"=>USUARIO_INACTIVO
			];     
	        //Enviamos al modelo
	        if(trim($id)===""){
	          //Alta
			  $id = $this->modelo->alta($data);

			  if($id>0) {
				$data["id"] = $id;
				if($this->enviarCorreo($data)) {
					$this->mensaje(
						"Alta de un usuario", 
		          		"Alta de un usuario", 
		          		"Se añadió correctamente el usuario: ".$nombres." ".$apellidos, 
		          		"usuarios/".$pagina, 
		          		"success"
					);
				} else {
					$this->mensaje(
						"Error al enviar el correo al usuario.", 
						"Error al enviar el correo al usuario.", 
						"Error al enviar el correo al usuario: ".$nombres." ".$apellidos, 
						"usuarios/".$pagina,
						"danger"
	          		);
				}
			  } else {
				$this->mensaje(
	          		"Error al añadir el usuario.", 
	          		"Error al añadir el usuario.", 
	          		"Error al modificar el usuario: ".$nombres." ".$apellidos, 
	          		"usuarios/".$pagina,
	          		"danger"
	          	);
			  }
	          Helper::mostrar($data);
	        } else {
			  //Modificar
			  if($this->modelo->modificar($data)){
				$this->mensaje(
					"Modificar el usuario", 
		          	"Modificar el usuario", 
		          	"Se modifico correctamente el usuario: ".$nombres." ".$apellidos, 
		          	"usuarios/".$pagina, 
		          	"success"
				);
			  }else {
				$this->mensaje(
					"Error al modificar el usuario.", 
	          		"Error al modificar el usuario.", 
	          		"Error al modificar el usuario: ".$nombres." ".$apellidos, 
	          		"usuarios/".$pagina,
	          		"danger"
				);
			  }
	        }
	      }
	    }
	    if(!empty($errores) || $_SERVER['REQUEST_METHOD']!="POST" ){
	    	//Vista Alta
	    	$tiposUsuarios = $this->modelo->getTipoUsuarios();
	    	$generos = $this->modelo->getGeneros();
	    	$estadosUsuarios = $this->modelo->getEstadosUsuarios();
		    $datos = [
		      "titulo" => "Alta de un usuario",
		      "subtitulo" => "Alta de un usuario",
		      "activo" => "usuarios",
		      "usuario"=>$this->usuario,
		      "menu" => true,
		      "admon" => true,
		      "errores" => $errores,
		      "tiposUsuarios" => $tiposUsuarios,
		      "estadosUsuarios" => $estadosUsuarios,
		      "generos" => $generos,
		      "data" => $data
		    ];
		    $this->vista("usuariosAltaVista",$datos);
	    }
	}

	public function modificar(string $id, string $pagina="1"):void {
		// leer los datos de tabla
		$data = $this->modelo->getId($id);
		$tiposUsuarios = $this->modelo->getTipoUsuarios();
	    $generos = $this->modelo->getGeneros();
	    $estadosUsuarios = $this->modelo->getEstadosUsuarios();
		$datos = [
			"titulo" => "Modificar un usuario",
			"subtitulo" => "Modificar un usuario",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"activo" => "usuarios",
			"tiposUsuarios" => $tiposUsuarios,
		    "estadosUsuarios" => $estadosUsuarios,
		    "generos" => $generos,
			"data" => $data
		];
		$this->vista("usuariosAltaVista",$datos);
	}
	
}
?>