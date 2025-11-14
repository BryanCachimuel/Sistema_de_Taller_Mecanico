<?php

/**
 * 
 */
class Imprimir extends fpdf {
    private $razonSocial = "";
    private $cliente = "";
    private $vehiculo = "";
    private $piezas = [];

    function __construct(string $razonSocial, string $cliente, string $vehiculo)
    {
        parent::__construct(); //super
        $this->razonSocial = $razonSocial;
        $this->cliente = $cliente;
        $this->vehiculo = $vehiculo;
    }

    // Cabecera de página
    public function Header() {}

    // Pie de página
    public function Footer() {}

    // Contenido del PDF
    public function cuerpoDocumento($piezas, $manoObra, $otros, $iva, $observacion) {}
}
