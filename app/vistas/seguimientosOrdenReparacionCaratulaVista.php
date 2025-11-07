<?php include_once("encabezado.php"); ?>
<div class="table-responsive">
  <table class="table table-striped" width="100%">
    <thead>
      <tr>
        <th>id</th>
        <th>Orden Reparación</th>
        <th>Fecha</th>
        <th>Observación</th>
        <th>Mostrar</th>
        <th>Modificar</th>
        <th>Borrar</th>
      </tr>
    </thead>
    <tbody>
      <?php
      for ($i = 0; $i < count($datos['data']); $i++) {
        print "<tr>";
        print "<td class='text-start'>" . $datos["data"][$i]['id'] . "</td>";
        print "<td class='text-start'>" . $datos["data"][$i]['vehiculo'] . "</td>";
        print "<td class='text-start'>" . $datos["data"][$i]['fecha'] . "</td>";
        print "<td class='text-start'>" . $datos["data"][$i]['observacion'] . "</td>";
        print "<td><a href='" . RUTA . "seguimientos/desplegarSeguimiento/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-warning'>Mostrar</a></td>";
        print "<td><a href='" . RUTA . "seguimientos/modificarSeguimiento/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-info'>Modificar</a></td>";
        print "<td><a href='" . RUTA . "seguimientos/borrarSeguimiento/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-danger'>Borrar</a></td>";
        print "</tr>";
      }
      ?>
    </tbody>
  </table>
  <?php include_once("paginacion.php"); ?>
  <a href="<?php print RUTA . 'seguimientos/alta/' . $datos['idOrdenReparacion']; ?>" class="btn btn-success">
    Dar de alta el seguimiento</a>
  <a href="<?php print RUTA; ?>seguimientos/1" class="btn btn-success">
    Regresar</a>
  <?php include_once("piepagina.php"); ?>