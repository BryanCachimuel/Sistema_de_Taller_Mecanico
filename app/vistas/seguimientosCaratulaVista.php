<?php include_once("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Vehículo</th>
    <th>Fecha ingreso</th>
    <th>Fecha salida</th>
    <th>Seguimiento</th>
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
      print "<td><a href='".RUTA."seguimientos/seguimiento/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-warning'><i class='fa-solid fa-list-check'></i> Seguimiento</a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
  <?php include_once("paginacion.php"); ?> 
<?php include_once("piepagina.php"); ?>					