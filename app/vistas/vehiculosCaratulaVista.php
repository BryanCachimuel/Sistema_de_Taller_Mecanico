<?php include_once("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Marca</th>
    <th>Modelo</th>
    <th>Año</th>
    <th>Placas</th>
    <th>Modificar</th>
    <th>Borrar</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['marca']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['modelo']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['anio']."</td>";
      print "<td class='text-left'>".$datos["data"][$i]['placas']."</td>";
      print "<td><a href='".RUTA."vehiculos/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'><i class='fa-solid fa-marker'></i></a></td>";
      print "<td><a href='".RUTA."vehiculos/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'><i class='fa-solid fa-trash-can'></i></a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
  <?php include_once("paginacion.php"); ?>
  <a href="<?php print RUTA; ?>vehiculos/alta" class="btn btn-success"><i class="fa-regular fa-square-plus"></i> Dar de alta un vehículo</a>
  </div>
<?php include_once("piepagina.php"); ?>