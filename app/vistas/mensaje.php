<?php include_once("encabezado.php"); 
print '<div class="alert '.$datos["color"].'" mt-3>';
print '<h4>'.$datos["texto"].'</h4>';
print '</div>';
if (isset($datos["url2"]) && !empty($datos["url2"])) {
	print '<a href="'.RUTA.$datos["url2"].'" class="btn '.$datos["colorBoton2"].'" >';
	print $datos["textoBoton2"].'</a>&nbsp;';
}
print '<a href="'.RUTA.$datos["url"].'" class="btn '.$datos["colorBoton"].'" >';
print $datos["textoBoton"].'</a>';
include_once("piepagina.php"); ?>