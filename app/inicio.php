<?php
define("LLAVE1","Hombresneciosque");
define("LLAVE2","acusaisalamujer");
define("CLAVE","mimamamemimamucho");
define('RUTA', '/taller/');
define("TAMANO_PAGINA",6);
define('PAGINAS_MAXIMAS',4);
//
//Tipos Usuarios
//
define('ADMON',1);
define('OPERADOR',2);
//
//Estados Usuario
//
define('USUARIO_ACTIVO',1);
define('USUARIO_INACTIVO',2);
define('USUARIO_SUSPENDIDO',3);
//
//Tipos Mecánico
//
define('MOTORES',1);
define('TRANSMISIONES',2);
define('FRENOS',3);
define('ELECTRICO',4);
define('HOJALATERIA',5);
//
//Estados mecánico
//
define('MECANICO_DISPONIBLE',1);
define('MECANICO_OCUPADO',2);
define('MECANICO_VACACIONES',3);
//
//Estados cliente
//
define('CLIENTE_ACTIVO',1);
define('CLIENTE_INACTIVO',2);
//
// Orden de Reparación
define('ORDEN_ABIERTA',1);
define('ORDEN_FACTURADA',2);

date_default_timezone_set('America/Guayaquil');

require_once("libs/Helper.php");
require_once("libs/Sesion.php");
require_once("libs/Controlador.php");
require_once("libs/Control.php"); 
require_once("libs/MySQLdb.php");
$control = new Control();
?>