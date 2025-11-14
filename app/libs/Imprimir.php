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
 public function cuerpoDocumento($piezas,$manoObra,$otros,$iva,$observacion) {
        $iva = floatval($iva) / 100;
        $manoObra = floatval($manoObra);
        $otros = floatval($otros);
        # Tabla de productos #
        $this->SetFont('Arial','',8);
        $this->SetFillColor(23,83,201);
        $this->SetDrawColor(23,83,201);
        $this->SetTextColor(255,255,255);
        $this->Cell(80,8,iconv("UTF-8", "ISO-8859-1","Descripción"),1,0,'C',true);
        $this->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Cant."),1,0,'C',true);
        $this->Cell(25,8,iconv("UTF-8", "ISO-8859-1","Precio"),1,0,'C',true);
        $this->Cell(29,8,iconv("UTF-8", "ISO-8859-1","Desc."),1,0,'C',true);
        $this->Cell(42,8,iconv("UTF-8", "ISO-8859-1","Subtotal"),1,0,'C',true);
        //
        $this->Ln(8);
        $this->SetTextColor(39,39,51);
        $materiales = 0;
        for ($i=0; $i < count($piezas) ; $i++) { 
            /*----------  Detalles de la tabla  ----------*/
            $this->Cell(80,7,iconv("UTF-8", "ISO-8859-1",$piezas[$i]["nombrePieza"]),'L',0,'C');
            $this->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$piezas[$i]["cantidad"]),'L',0,'C');
            $this->Cell(25,7,iconv("UTF-8", "ISO-8859-1",number_format($piezas[$i]["costo"],2)),'L',0,'C');
            $this->Cell(29,7,iconv("UTF-8", "ISO-8859-1",""),'L',0,'R');
            $this->Cell(42,7,iconv("UTF-8", "ISO-8859-1",number_format($piezas[$i]["costo"]*$piezas[$i]["cantidad"],2)),'LR',0,'R');
            $this->Ln(7);
            $materiales+= $piezas[$i]["costo"]*$piezas[$i]["cantidad"];
        }
        $this->SetFont('Arial','B',9);
    
        # Impuestos & totales #
        $this->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
        $this->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1","MATERIALES"),'T',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1",number_format($materiales,2)),'T',0,'R');

        $this->Ln(7);

        $this->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1","MANO DE OBRA"),'',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1",number_format($manoObra,2)),'',0,'R');

        $this->Ln(7);

        $this->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1","OTROS CARGOS"),'',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1",number_format($otros,2)),'',0,'R');
        $total = $materiales + $manoObra + $otros;
        $iva = $total * $iva;
        $this->Ln(7);

        $this->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1","IVA"),'',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1",number_format($iva,2)),'',0,'R');
        $total = $materiales + $manoObra + $otros + $iva;
        $this->Ln(7);

        $this->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1","Total"),'T',0,'C');
        $this->Cell(38,7,iconv("UTF-8", "ISO-8859-1",number_format($total,2)),'T',0,'R');

        $this->Ln(7);

        $this->Ln(12);
        $this->SetFont('Arial','',9);

        $this->SetTextColor(39,39,51);
        $this->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1",$observacion),0,'C',false);
        $this->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1","Cualquier duda o reclamación es indispensable presentar este documento."),0,'C',false);
	}

}
