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
    public function Header() {
         // Logo
        $this->Image('img/placeholder.jpg',150,8,50,40,"JPG");
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        $this->SetMargins(10,10,10);
        // Título
        $this->MultiCell(190,6,utf8_decode($this->razonSocial),0,'L');
        // Salto de línea
        $this->Line(10, 54, 200, 54);
        $this->Ln(4);
        // Título
        $this->SetFont('Arial','',10);
        $this->MultiCell(190,5,utf8_decode($this->cliente),0,'L');
        $this->Line(10, 82, 200, 82);
        $this->Ln(4);
        $this->MultiCell(190,5,utf8_decode($this->vehiculo),0,'L');
        $this->Line(10, 112, 200, 112);
        $this->Ln(6);
    }

    // Pie de página
    public function Footer() {}

    // Contenido del PDF
    public function cuerpoDocumento($piezas, $manoObra, $otros, $iva, $observacion) {}
}
