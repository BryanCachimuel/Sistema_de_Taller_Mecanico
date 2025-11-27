<?php include_once("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Pieza</th>
    <th class='text-center'>Cantidad</th>
    <th class='text-end'>Costo</th>
    <th class='text-end'>Total</th>
  </tr>
  </thead>
  <tbody>
    <?php
    $total_suma = $cantidad_suma = 0;
    for($i=0; $i<count($datos['detalle']); $i++){
      $total = $datos["detalle"][$i]['cantidad'] * $datos["detalle"][$i]['costo'];
      print "<tr>";
      print "<td class='text-center'>".$datos["detalle"][$i]['id']."</td>";
      print "<td class='text-start'>".$datos["detalle"][$i]['nombrePieza']."</td>";
      print "<td class='text-center'>".number_format($datos["detalle"][$i]['cantidad'])."</td>";
      print "<td class='text-end'>".number_format($datos["detalle"][$i]['costo'],2)."</td>";
      print "<td class='text-end'>".number_format($total,2)."</td>";
      $total_suma+= $total;
      $cantidad_suma+= $datos["detalle"][$i]['cantidad'];
    }
    //Totales
    print "<tr class='table-dark'>";
    print "<td>Total:</td>";
    print "<td>&nbsp;</td>";
    print "<td class='text-center'>".number_format($cantidad_suma)."</td>";
    print "<td>&nbsp;</td>";
    print "<td class='text-end'>".number_format($total_suma,2)."</td>";
    print "</tr>";
    ?>
  </tbody>
  </table>
  <?php if(isset($datos["baja"])){ ?>
  <a href="<?php print RUTA.'ordenAlmacen/bajaLogica/'.$datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">Borrar la orden de almacén</a>
  <?php } ?>
  <a href="<?php print RUTA.'ordenAlmacen/'.$datos['pag']; ?>" class="btn btn-success">
  Regresar</a>
  <?php if(isset($datos["baja"])){ 
    print '<p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>';
  }?>
  </div>
<?php include_once("piepagina.php"); ?>