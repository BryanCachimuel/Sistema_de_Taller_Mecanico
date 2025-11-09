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
					if ($this->subirImagenes($_FILES,$idOrdenReparacion,$id)) {
						$this->mensaje(
							"Alta del seguimiento de una orden de reparación.", 
							"Alta del seguimiento de una orden de reparación.", 
							"Se añadió correctamente el seguimiento a la orden de reparación.", 
							"seguimientos/".$pagina, 
							"success"
						);
					} else {
						$this->mensaje(
			          		"Error al subir las imágenes.", 
			          		"Error al su|r las imágenes.", 
			          		"Error al subir las imágenes.", 
			          		"seguimientos/".$pagina,
			          		"danger"
			          	);
					}
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

	public function subirImagenes($fotos_array,$idOrdenReparacion,$idSeguimiento ):bool {
		$salida = true;
		if($fotos_array['fotos']){
			$tipos_array = ["image/jpeg","image/gif","image/png"];
			$carpeta = 'fotos/'.$idOrdenReparacion."/".$idSeguimiento."/";
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0777, true);
			}
			//
			$archivos_array = [];
			$archivos_num = count($fotos_array['fotos']['name']);
			$archivos_keys = array_keys($fotos_array['fotos']);
			//
			for ($i=0; $i<$archivos_num; $i++) {
				foreach ($archivos_keys as $key) {
					$archivos_array[$i][$key] = $fotos_array['fotos'][$key][$i];
				}
			}
			//
			foreach ($archivos_array as $archivo) {
				$nombre = uniqid();
				$extension =$archivo['type'];
				if ($archivo['size']<40*1024*1024) {
					if (in_array($extension, $tipos_array)) {
						if ($extension==$tipos_array[0]) {
							$nombre.= $nombre.".jpg";
						} else if ($extension==$tipos_array[1]) {
							$nombre.= $nombre.".gif";
						} else if ($extension==$tipos_array[2]) {
							$nombre.= $nombre.".png";
						} 
						//Subir el archivo
						if (is_uploaded_file($archivo['tmp_name'])) {
							//copiamos el archivo temporal
							copy($archivo['tmp_name'],$carpeta.$nombre);
						} 
					} else {
						$salida = false;
					}
				} else {
					$salida = false;
				}
			}
	  	}
	  	return $salida;
	}

}
?>