<?php

class Tablero extends Controlador
{
    private $modelo = "";
    private $sesion;

    function __construct()
    {
        // se crea una sesión
        $this->sesion = new Sesion();
        if($this->sesion->getLogin()){
            $this->modelo = $this->modelo("TableroModelo");
            $this->usuario = $this->sesion->getUsuario();
        } else {
            header("location:".RUTA);
        }
    }

    public function caratula()
    {
        $datos = [
            "titulo" => "Sistema de Taller Mecánico",
            "subtitulo" => $this->usuario["nombre"]." ".$this->usuario["apellido"],
            "usuario" => $this->usuario,
            "data" => [],
            "menu" => true
        ];
        $this->vista("tableroCaratulaVista", $datos);
    }

  

   

    

}
