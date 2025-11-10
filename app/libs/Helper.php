<?php  
/**
 * 
 */
class Helper
{
	
	function __construct(){}

	public static function cadena($cadena){
		//
		$buscar  = array('^', 'delete', 'drop','truncate','exec','system');
		$reemplazar = array('-', 'dele*te', 'dr*op','truneca*te','ex*ec','syst*em');
		$cadena = trim(str_replace($buscar, $reemplazar, $cadena));
		$cadena = addslashes(htmlentities($cadena));
		return $cadena;
	}

	public static function correo($correo='')
	{
		return filter_var($correo, FILTER_VALIDATE_EMAIL);
	}

	public static function encriptar(string $data):string
	{
		return base64_encode(LLAVE1.$data.LLAVE2);
	}

	public static function desencriptar(string $data):string
	{
		$cadena = base64_decode($data);
		if (str_contains($cadena, LLAVE1)) {
			$cadena = str_replace(LLAVE1,"",$cadena);
			if (str_contains($cadena, LLAVE2)) {
				$cadena = str_replace(LLAVE2,"",$cadena);
			} else{
				$cadena = "error";
			}
		} else{
			$cadena = "error";
		}
		return $cadena;
	}

	public static function fecha(string $cadena=""):bool{
		//ISO AAAA-MM-DD
		$salida = false;
		if ($cadena!="") {
		$fecha_array = explode("-", $cadena);
		$salida = checkdate($fecha_array[1], $fecha_array[2], $fecha_array[0]);
		}
		return $salida;
	}

	public static function generarClave(int $lon):string
	{
		$llave = "";
		$cadena = "1234567890ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvwxyz+*-_";
		$max = strlen($cadena)-1;
		for($i = 0; $i < $lon; $i++){
		  $llave .= substr($cadena, mt_rand(0,$max), 1);
		}
		return $llave;
	}

	public static function numero(string $cadena):string
	{
		$buscar  = array(' ', '$', ',');
		$reemplazar = array('', '', '');
		$numero = str_replace($buscar, $reemplazar, $cadena);
		$numero = filter_var($numero, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
		return $numero;
	}

	public static function mostrar($data,$detener=true):void
	{
		print "<pre>";
		var_dump($data);
		print "</pre>";
		if ($detener) {
			exit();
		}
	}

	public static function medidaSize(string $bytes):string {
		 $bytes = floatval($bytes);
      	 $bytes_array = array(
			0 => array(
				"UNIT" => "TB",
				"VALUE" => pow(1024, 4)
			),
			1 => array(
				"UNIT" => "GB",
				"VALUE" => pow(1024, 3)
			),
			2 => array(
				"UNIT" => "MB",
				"VALUE" => pow(1024, 2)
			),
			3 => array(
				"UNIT" => "KB",
				"VALUE" => 1024
			),
			4 => array(
				"UNIT" => "B",
				"VALUE" => 1
			),
			);
			foreach($bytes_array as $item)
			{
				if($bytes >= $item["VALUE"])
				{
					$salida = $bytes / $item["VALUE"];
					$salida = strval(round($salida, 2))." ".$item["UNIT"];
					break;
				}
			}
			return $salida;
	}

	
}



?>