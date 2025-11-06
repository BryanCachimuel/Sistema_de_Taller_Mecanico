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
    <th class='text-center'>Borrar</th>
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
      print "<td class='text-center'>".$datos["detalle"][$i]['cantidad']."</td>";
      print "<td class='text-end'>$".number_format($datos["detalle"][$i]['costo'])."</td>";
      print "<td class='text-end'>$".number_format($total)."</td>";
      print "<td class='text-center'><a href='".RUTA."ordenAlmacen/borrarPieza/".$datos["detalle"][$i]["id"]."/".$datos["pag"]."' class='btn btn-danger'>Borrar</a></td>";
      print "</tr>";
      $total_suma+= $total;
      $cantidad_suma+= $datos["detalle"][$i]['cantidad'];
    }
    //Totales
    print "<tr class='table-dark'>";
    print "<td>Total:</td>";
    print "<td>&nbsp;</td>";
    print "<td class='text-center'>".number_format($cantidad_suma)."</td>";
    print "<td>&nbsp;</td>";
    print "<td class='text-end'>".number_format($total_suma)."</td>";
    print "<td>&nbsp;</td>";
    print "</tr>";
    ?>
  </tbody>
  </table>
  <a href="<?php print RUTA.'ordenAlmacen/anadeOrdenAlmacenPieza/'.$datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-success">
  Añadir un producto</a>
  <a href="<?php print RUTA.'ordenAlmacen/terminarOrdenAlmacen/'.$datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-success">
  Terminar la órden de almacén</a>
  <a href="<?php print RUTA.'ordenAlmacen/cancelarOrdenAlmacen/'.$datos['data']['id'].'/'.$datos['pag']; ?>" class="btn btn-danger">
  Cancelar la órden de almacén</a>
  </div>
<?php include_once("piepagina.php"); ?>