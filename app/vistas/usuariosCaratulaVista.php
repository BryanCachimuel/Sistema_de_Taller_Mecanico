<?php include_once("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>id</th>
    <th>Nombre</th>
    <th>Tipo usuario</th>
    <th>Estado</th>
    <th>Modificar</th>
    <th>Borrar</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=0; $i<count($datos['data']); $i++){
      print "<tr>";
      print "<td class='text-start'>".$datos["data"][$i]['id']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['nombre']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['tipoUsuario']."</td>";
      print "<td class='text-start'>".$datos["data"][$i]['estado']."</td>";
      print "<td><a href='".RUTA."usuarios/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'><i class='fa-solid fa-marker'></i></a></td>";
      print "<td><a href='".RUTA."usuarios/borrar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-danger'><i class='fa-solid fa-trash-can'></i></a></td>";
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
  <?php include_once("paginacion.php"); ?> 
<a href="<?php print RUTA; ?>usuarios/alta" class="btn btn-success"><i class="fa-regular fa-square-plus"></i> Dar de alta un usuario</a>
<?php include_once("piepagina.php"); ?>					