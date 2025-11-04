<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>ordenAlmacen/borrarOrdenAlmacenPieza/" method="POST">
  
  <div class="form-group text-left">
      <label for="pieza">Pieza:</label>
      <input type="text" name="pieza" id="pieza" class="form-control"  value="<?php print isset($datos['data']['nombrePieza'])?$datos['data']['nombrePieza']:''; ?>" readonly>
  </div>

  <div class="form-group text-left">
      <label for="cantidad">Cantidad:</label>
      <input type="text" name="cantidad" id="cantidad" class="form-control" value="<?php print isset($datos['data']['cantidad'])?$datos['data']['cantidad']:''; ?>" readonly>
  </div>

  <div class="form-group text-start">
    <input type="hidden" name="idOrdenAlmacen" id="idOrdenAlmacen" value="<?php if (isset($datos['data']['idOrdenAlmacen'])) { print $datos['data']['idOrdenAlmacen']; } else { print ""; } ?>">
    <input type="hidden" name="idOrdenAlmacenDetalle" id="idOrdenAlmacenDetalle" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
    <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <input type="submit" value="Borrar pieza" class="btn btn-danger">
      <a href="<?php print RUTA; ?>ordenalmacen" class="btn btn-danger">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>