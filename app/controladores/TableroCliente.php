<?php  
/**
 * 
 */
class TableroCliente extends Controlador
{
	protected $usuario="";
	protected $modelo = "";
	protected $sesion;
	
	function __construct()
	{
		//Creamos sesion
		$this->sesion = new Sesion();
		if ($this->sesion->getLogin()) {
			$this->modelo = $this->modelo("TableroClienteModelo");
			$this->usuario = $this->sesion->getUsuario();
		} else {
			header("location:".RUTA);
		}
	}

	public function caratula(string $pagina="1")
	{
		$data = $this->modelo->getTablaOrdenReparacion($this->usuario["id"]);
		$datos = [
			"titulo" => "Órdenes de reparación",
			"subtitulo" => "Órdenes de reparación: ".$this->usuario["nombres"]." ".$this->usuario["apellidos"],
			"usuario"=>$this->usuario,
			"data"=>$data,
			"menu" => false
		];
		$this->vista("tableroClienteCaratulaVista",$datos);
	}

	public function logout()
	{
		if (isset($_SESSION['usuario'])) {
			$this->sesion->finalizarLogin();
		}
		header("location:".RUTA);
	}

	public function desplegarSeguimiento(string $idSeguimiento=''):void
	{
		$data = $this->modelo->getSeguimientoId($idSeguimiento);
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
			"menu" => false,
			"admon" => false,
			"usuario"=>$this->usuario,
			"archivos" => $archivos_array,
			"data" => $data
		];
		$this->vista("tableroClienteArchivosVista",$datos);
	}

	public function mostrar(string $id,string $pagina="1"):void
	{
		//ElYNBw1B_R
		//4jG7RrfQ2y
		//Leemos los datos de la tabla
		$data = $this->modelo->getId($id);
	    $piezas = $this->modelo->getPiezas($id);
	    $seguimientos = $this->modelo->getSeguimientos($id);
		$datos = [
			"titulo" => "Mostrar una orden de reparación",
			"subtitulo" =>"Mostrar una orden de reparación",
			"menu" => false,
			"admon" => false,
			"usuario" => $this->usuario,
			"seguimientos" => $seguimientos,
		    "piezas" => $piezas,
			"pagina" => $pagina,
			"data" => $data
		];
		$this->vista("tableroClienteMostrarVista",$datos);
	}

	public function mostrarImagen(string $id="",string $i=""):void
	{
		$data = $this->modelo->getSeguimientoId($id);
		$carpeta = "fotos/".$data["idOrdenReparacion"]."/".$data["id"]."/";
		$foto = "";
      	if (file_exists($carpeta)) {
        	$archivos_array = scandir($carpeta);
        	$foto = $carpeta.$archivos_array[$i];
      	} else {
        	$archivos_array = [];
      	}
    	$this->mensaje(
    		"Mostrar una imagen", 
    		"Archivo: ".$archivos_array[$i], 
    		"<img src='".RUTA.'public/'.$carpeta.$archivos_array[$i]."' width='100%'/>", 
    		"tableroCliente/mostrar/".$data["idOrdenReparacion"], 
    		"success"
    	);
	}
}
?>