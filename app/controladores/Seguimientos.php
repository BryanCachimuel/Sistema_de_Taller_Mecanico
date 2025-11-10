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
					if ($this->subirImagenes($_FILES,$idOrdenReparacion,$idSeguimiento)) {
						$this->mensaje(
							"Modificación del seguimiento de una orden de reparación.", 
							"Modificación del seguimiento de una orden de reparación.", 
							"Se modificó correctamente el seguimiento a la orden de reparación.", 
							"seguimientos/".$pagina, 
							"success"
						);
					} else {
						$this->mensaje(
			          		"Error al subir las imágenes.", 
			          		"Error al subir las imágenes.", 
			          		"Error al subir las imágenes.", 
			          		"seguimientos/".$pagina,
			          		"danger"
			          	);
					}
				} else {
					$this->mensaje(
						"Error al modificar el seguimiento.", 
						"Error al modificar el seguimiento.", 
						"Error al modificar el seguimiento.", 
						"seguimientos/".$pagina, 
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

	public function borrarImagen(string $id="", string $i="", string $pagina="1") {
		$this->mensaje(
    		"Baja de una imagen", 
    		"Baja de una imagen", 
    		"¿Desea borrar la imagen? Una vez borrada la imagen no podrá ser recuperada.", 
    		"seguimientos/desplegarSeguimiento/".$id."/".$pagina, 
    		"danger",
    		"seguimientos/borrarArchivo/".$id."/".$i."/".$pagina,
    		"danger",
    		"Borrar"
    	);
	}

	public function borrarArchivo(string $id,string $i,string $pagina):void {
		$data = $this->modelo->getId($id);
		$carpeta = "fotos/".$data["idOrdenReparacion"]."/".$data["id"]."/";
		$foto = "";
		$salida = false;
      	if(file_exists($carpeta)) {
        	$archivos_array = scandir($carpeta);
        	$foto = $carpeta.$archivos_array[$i];
        	if(file_exists($foto)){
        		unlink($foto);
        		$salida = true;
        	}
      	}
      	if($salida) {
      		$this->mensaje(
        		"Borrar una imagen", 
        		"Borrar una imagen", 
        		"Se borró correctamente la imagen: ".$foto, 	
        		"seguimientos/desplegarSeguimiento/".$id."/".$pagina,
        		"success"
        	);
      	}else {
      		$this->mensaje(
        		"Borrar una imagen", 
        		"Borrar una imagen", 
        		"Error al borrar la imagen: ".$foto, 
        		"seguimientos/".$pagina, 
        		"danger"
        	);
      	}
	}

	public function borrarSeguimiento(string $id="",string $pagina="1"){
		//Leemos los datos del registro del id
		$data = $this->modelo->getId($id);
		$datos = [
			"titulo" => "Baja de un seguimiento",
			"subtitulo" => "Baja de un seguimiento",
			"menu" => true,
			"admon" => true,
			"errores" => [],
			"activo" => 'seguimientos',
			"usuario" => $this->usuario,
			"data" => $data,
			"pagina" => $pagina,
			"idOrdenReparacion" => $data["idOrdenReparacion"],
			"baja" => true
		];
		$this->vista("seguimientosAltaVista",$datos);
	}

	public function bajaLogica(string $id='',string $pagina="1"):void{
		if ($id!="") {
			$data = $this->modelo->getId($id);
			if ($this->modelo->bajaLogica($id)) {
				$carpeta = "fotos/".$data["idOrdenReparacion"]."/".$data["id"];
				$archivos = glob($carpeta . '/*');
			    foreach ($archivos as $archivo) {
			        if (is_file($archivo)) {
			            unlink($archivo);
			        } 
			    }
			    if (file_exists($carpeta)) {
			   		rmdir($carpeta);
			   	}
				$this->mensaje(
				"Baja de un seguimiento a la orden de reparación", 
				"Baja de un seguimiento a la orden de reparación", 
				"Se borró correctamente el seguimiento a la orden de reparación.", 
				"seguimientos/".$pagina, 
				"success");
			} else {
				$this->mensaje(
				"Baja de un seguimiento a la orden de reparación", 
				"Baja de un seguimiento a la orden de reparación", 
				"Error al borrar un seguimiento a la orden de reparación: ".$id, 
				"seguimientos/".$pagina,
				"danger");
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

	public function desplegarSeguimiento(string $idSeguimiento='', string $pagina="1"):void {
		$data = $this->modelo->getId($idSeguimiento);
		$id = $data["idOrdenReparacion"];
		$carpeta = "fotos/".$id."/".$idSeguimiento;
      	if (file_exists($carpeta)) {
        	$archivos_array  = scandir($carpeta);
      	} else {
        	$archivos_array  = [];
      	}
		$datos = [
			"titulo" => "Imágenes de la orden de reparación",
			"subtitulo" =>"Imágenes de la orden de reparación",
			"menu" => true,
			"admon" => true,
			"usuario"=>$this->usuario,
			"activo" => "seguimientos",
			"archivos" => $archivos_array,
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("seguimientosArchivosVista",$datos);
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

	public function modificarSeguimiento(string $idSeguimiento, string $pagina="1"):void {
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($idSeguimiento);
		//
		$datos = [
			"titulo" => "Modificar el seguimiento",
			"subtitulo" =>"Modificar el seguimiento",
			"menu" => true,
			"admon" => true,
			"usuario" => $this->usuario,
			"activo" => "seguimientos",
			"idOrdenReparacion"=>$data["idOrdenReparacion"],
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("seguimientosAltaVista",$datos);
	}

	public function mostrarImagen(string $id="", string $i="", string $pagina="1"):void {
		$data = $this->modelo->getId($id);
		$carpeta = "fotos/".$data["idOrdenReparacion"]."/".$data["id"]."/";
		$foto = "";
      	if(file_exists($carpeta)) {
        	$archivos_array = scandir($carpeta);
        	$foto = $carpeta.$archivos_array[$i];
      	}else {
        	$archivos_array = [];
      	}
    	$this->mensaje(
    		"Mostrar una imagen", 
    		"Archivo: ".$archivos_array[$i], 
    		"<img src='".RUTA.'public/'.$carpeta.$archivos_array[$i]."' width='100%'/>", 
    		"seguimientos/desplegarSeguimiento/".$id."/".$pagina, 
    		"success"
    	);
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