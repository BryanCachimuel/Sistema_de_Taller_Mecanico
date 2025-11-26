<?php  
/**
 * 
 */
class Controlador
{
	
	function __construct(){}

	public function enviarCorreo(array $data=[]):bool
	{
		$salida = false;
		if (!empty($data)) {
			$id = Helper::encriptar($data["id"]);
			//
			$msg = "Entra a la siguiente liga para cambiar tu clave de acceso al sistema de control de mi taller mecánico...<br>";
			$msg.= "<a href='".RUTA."login/cambiarclave/".$id."'>Cambiar tu clave de acceso</a>";

			$headers = "MIME-Version: 1.0\r\n"; 
			$headers.= "Content-type:text/html; charset=UTF-8\r\n"; 
			$headers.= "From: Taller Mecanico\r\n"; 
			$headers.= "Reply-to: ayuda@taller.com\r\n";

			$asunto = "Cambiar clave de acceso";
			Helper::mostrar($msg);
			//$salida = @mail($data["correo"],$asunto,$msg, $headers);
		}
		return $salida;
	}

	public function modelo(string $modelo='')
	{
		if (file_exists("../app/modelos/".$modelo.".php")) {
			require_once("../app/modelos/".$modelo.".php");
			return new $modelo;
		} else {
			die("El modelo ".$modelo." no existe");
		}
		
	}

	public function vista($vista='',$datos=[])
	{
		if (file_exists("../app/vistas/".$vista.".php")) {
			require_once("../app/vistas/".$vista.".php");
		} else {
			die("La vista ".$vista." no existe");
		}
	}

	public function mensaje($titulo='',$subtitulo,$texto,$url,$color,$url2="",$color2="",$texto2="")
	  {
	    $datos = [
	      "titulo" => $titulo,
	      "menu" => true,
	      "errores" => [],
	      "data" => [],
	      "subtitulo" => $subtitulo,
	      "texto" => $texto,
	      "url" => $url,
	      "color" => "alert-".$color,
	      "colorBoton" => "btn-".$color,
	      "textoBoton" => "Regresar",
	      "url2" => $url2,
	      "colorBoton2" => "btn-".$color2,
	      "textoBoton2" => $texto2
	      ];
	      $this->vista("mensaje",$datos);
	      exit;
	  }

	public function perfil()
	{
		$errores = [];
		if ($this->usuario["tipoUsuario"]==ADMON) {
			$regreso = "tablero";
		} else if ($this->usuario["tipoUsuario"]==MECANICO) {
			$regreso = "tableroMecanico";
		} else if ($this->usuario["tipoUsuario"]==CLIENTE) {
			$regreso = "tableroCliente";
		}
		//
		if ($_SERVER['REQUEST_METHOD']=="POST") {
			//
			$id = $_POST['id']??"";
			$nombres = Helper::cadena($_POST['nombres']??"");
			$apellidos = Helper::cadena($_POST['apellidos']??"");
			$nueva = $_POST['clave']??"";
			$verifica = $_POST['verifica']??"";

			if(empty($nombres)){
				array_push($errores, "El nombre del usuario no puede estar vacío.");
			}
			if(empty($apellidos)){
				array_push($errores, "El apellido paterno no puede estar vacío.");
			}
			if(!(empty($nueva) && empty($verifica)) ){
				if(empty($verifica)){
					array_push($errores, "La nueva clave de acceso de verificación no puede estar vacía.");
				}
				if($nueva!=$verifica){
					array_push($errores, "Las claves de acceso no coinciden.");
				}
			}
			//
			if (empty($errores)) {
				if ($this->modelo->setUsuario($id, $nombres, $apellidos,$nueva)) {
					$data = $this->modelo->getUsuarioId($id);
					$data["tipoUsuario"] = $this->usuario["tipoUsuario"];
					$this->sesion->setUsuario($data);
					 $this->mensaje(
		          		"Modificación del perfil exitoso", 
		          		"Modificación del perfil exitoso", 
		          		"Modificación del perfil exitoso ", 
		          		$regreso, 
		          		"success"
		          	);
				} else {
					$this->mensaje(
		          		"Error al modificar del perfil", 
		          		"Error al modificar del perfil", 
		          		"Error al modificar del perfil", 
		          		$regreso, 
		          		"danger"
		          	);
				}
			}
		}
		//
		$datos = [
			"titulo"=> "Perfil del usuario",
			"subtitulo" => "Perfil del usuario",
			"admon" => $this->usuario["tipoUsuario"],
			"menu" => true,
			"regreso" => $regreso,
			"activo" => "perfil",
			"errores" => $errores,
			"data" => $this->usuario
		];
		$this->vista("tableroPerfilVista",$datos);
	}
}

?>