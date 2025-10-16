<?php
define("LLAVE1","Hombresneciosque");
define("LLAVE2","acusaisalamujer");
define("CLAVE","mimamamemimamucho");
define('RUTA','/taller/');
// Tipos de Usuarios
define('ADMON', 1);
define('OPERADOR', 2);

require_once("libs/Helper.php");
require_once("libs/Sesion.php");
require_once("libs/Controlador.php");
require_once("libs/Control.php");
require_once("libs/MySQLdb.php");
$control = new Control();
