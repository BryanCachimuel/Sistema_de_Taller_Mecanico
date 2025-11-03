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

}

?>