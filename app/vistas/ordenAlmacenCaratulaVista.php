<?php include_once("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Orden Reparación</th>
    <th>Costo</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Mostrar</th>
    <th>Borrar</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-start'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['vehiculo']."</td>";
      print "<td class='text-start'>$".number_format($datos["data"][$i]['costo'],2)."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['alta_dt']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['estado']."</td>";
      print "<td><a href='".RUTA."ordenAlmacen/desplegarOrdenAlmacen/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning'>Mostrar</a></td>";
      print "<td><a href='".RUTA."ordenAlmacen/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger ";
      if ($datos["data"][$i]["idEstado"]==ORDEN_FACTURADA) {
        print " disabled ";
      }
      print "'>Borrar</a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
  <?php include_once("paginacion.php"); ?> 
<a href="<?php print RUTA; ?>ordenAlmacen/alta" class="btn btn-success">
  Dar de alta una orden de almacén</a>
<?php include_once("piepagina.php"); ?>					