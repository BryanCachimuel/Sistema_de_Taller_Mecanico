<?php include_once("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Vehículo</th>
    <th>Fecha Ingreso</th>
    <th>Fecha Salida</th>
    <th>Estado</th>
    <th>Salida</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-start'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['vehiculo']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['fechaIngreso']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['fechaSalida']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['estado']."</td>";
      print "<td><a href='".RUTA."salidas/salida/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning";
      if ($datos["data"][$i]['edo']==ORDEN_FACTURADA) {
        print " disabled";
      }
      print "'>Salida</a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
  <?php include_once("paginacion.php");   
  include_once("piepagina.php"); ?>         