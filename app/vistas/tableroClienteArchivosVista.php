<?php include_once("encabezado.php"); ?>
  <div class="table-responsive">
  <table class="table table-striped" width="100%">
  <thead>
    <tr>
    <th>Archivo</th>
    <th>Tamaño</th>
    <th>Foto</th>
  </tr>
  </thead>
  <tbody>
    <?php
    for($i=2; $i<count($datos['archivos']); $i++){
      $carpeta = "fotos/".$datos["data"]['idOrdenReparacion']."/".$datos["data"]['id']."/";
      print "<tr>";
      print "<td class='text-start'>".$datos["archivos"][$i]."</td>";
      if (file_exists($carpeta)) {
        print "<td class='text-start'>".Helper::medidaSize(filesize($carpeta.$datos["archivos"][$i]))."</td>";
        print "<td class='text-start'><a href='".RUTA."tableroCliente/mostrarImagen/".$datos["data"]["id"]."/".$i."'>";
        print "<img src='".RUTA."public/".$carpeta.$datos["archivos"][$i]."' width='40'/></td>";
      } else {
        print "<td>Error en la</td>";
        print "<td>lectura del</td>";
        print "<td>archivo</td>";
      }
      print "</tr>";
    }
    ?>
  </tbody>
  </table>
</div>
  <a href="<?php print RUTA.'tableroCliente/mostrar/'.$datos["data"]['idOrdenReparacion'];?>" class="btn btn-success">
  Regresar</a>
<?php include_once("piepagina.php"); ?>					