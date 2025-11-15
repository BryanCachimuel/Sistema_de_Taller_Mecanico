<?php  
/**
 * 
 */
class Vehiculos extends Controlador
{
	private $modelo = "";
	private $usuario;
	private $sesion;
	
	function __construct()
	{
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("VehiculosModelo");
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
	        array_push($errores,"El modelo del vehículo es requerido.");
	      }
	      if(empty($anio)){
	        array_push($errores,"El año del vehículo es requerido.");
	      }
	      if($color=="void"){
	        array_push($errores,"El color del vehículo es obligatorio.");
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
							"Modificar el vehículo", 
							"Modificar el vehículo", 
							"Se modificó correctamente el vehículo: ".$marca." ".$modelo,
							"vehiculos/".$pagina, 
							"success"
						);
				} else {
					$this->mensaje(
						"Error al modificar el vehículo.", 
						"Error al modificar el vehículo.", 
						"Error al modificar el vehículo: ".$marca." ".$modelo, 
						"vehiculos/".$pagina, 
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

	public function borrar(string $id="",string $pagina="1"):void {
		//Leemos los datos del registro del id
		$data = $this->modelo->getId($id);
		$clientes = $this->modelo->getClientes();
		//Integridad referencial
    	$ir_array = $this->modelo->getIntegridadReferencial($id);

		if ($ir_array[0]==0) {
			$datos = [
			  "titulo" => "Baja de un vehículo",
			  "subtitulo" => "Baja de un vehículo",
			  "menu" => true,
			  "admon" => true,
			  "usuario" => $this->usuario,
			  "errores" => [],
			  "activo" => 'vehiculos',
			  "data" => $data,
			  "pagina" => $pagina,
			  "clientes" => $clientes,
			  "baja" => true
			];
			$this->vista("vehiculosAltaVista",$datos);
		} else {
			$m = "No podemos eliminar al vehículo porque tiene:<ul>";
			if ($ir_array[1]==1) {
				$m.="<li>Una Orden de reparación.</li>";
			} else if ($ir_array[1]>1) {
				$m.="<li>".$ir_array[1]." Órdenes de reparación.</li>";
			}
			$m.="</ul>Primero debe eliminar esas referencias.";
			$this->mensaje(
	    		"Error al borrar al vehículo", 
	    		"Error al borrar al vehículo", 
	    		$m, 
	    		"vehiculos", 
	    		"danger"
	    	);
		}
	}

	public function bajaLogica(string $id='',string $pagina="1"):void
	{
		if (isset($id) && $id!="") {
			if ($this->modelo->bajaLogica($id)) {
				$this->mensaje(
					"Baja de un vehículo", 
					"Baja de un vehículo", 
					"Se borró correctamente al vehículo: ".$id, 
					"vehiculos/".$pagina, 
					"success"
				);
	        } else {
	        	$this->mensaje(
	        		"Baja de un vehículo", 
	        		"Baja de un vehículo", 
	        		"Error al borrar al vehículo: ".$id, 
	        		"vehiculos/".$pagina,
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
			"titulo" => "Vehículos",
			"subtitulo" => "Vehículos",
			"usuario"=>$this->usuario,
			"data"=>$data,
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

	public function modificar(string $id,string $pagina="1"):void
	{
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
	    $clientes = $this->modelo->getClientes();
		$datos = [
			"titulo" => "Modificar un vehículo",
			"subtitulo" =>"Modificar un vehículo",
			"menu" => true,
			"admon" => true,
			"usuario" => $this->usuario,
			"activo" => "vehiculos",
			"clientes" => $clientes,
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("vehiculosAltaVista",$datos);
	}
}
?>