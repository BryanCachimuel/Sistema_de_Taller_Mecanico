<?php
// Tipos de Usuarios
define('ADMON', 1);
define('OPERADOR', 2);

require_once("libs/Helper.php");
require_once("libs/Controlador.php");
require_once("libs/Control.php");
require_once("libs/MySQLdb.php");
$control = new Control();
