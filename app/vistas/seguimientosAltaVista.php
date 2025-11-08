<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>seguimientos/alta/" method="POST" enctype="multipart/form-data">

  <div class="form-group text-left">
    <label for="fecha">* Fecha de seguimiento:</label>
    <input type="date" name="fecha" id="fecha" class="form-control" required value="<?php print isset($datos['data']['fecha'])?$datos['data']['fecha']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
  </div>

  <div class="form-group text-left">
      <label for="observacion">Observación:</label>
      <textarea class="form-control" id="observacion" name="observacion" rows="3" <?php if (isset($datos["baja"])) { print " disabled "; }?>><?php print isset($datos['data']['observacion'])?$datos['data']['observacion']:''; ?></textarea>
    </div>

  <div class="form-group text-left">
      <label for="fotos">Foto:</label>
      <input type="file" name="fotos[]" id="fotos" multiple class="form-control" value="<?php print isset($datos['data']['fotos'])?$datos['data']['fotos']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

 
    <div class="form-group text-start mb-3">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">
      <input type="hidden" name="idOrdenReparacion" id="idOrdenReparacion" value="<?php if (isset($datos['idOrdenReparacion'])) { print $datos['idOrdenReparacion']; } else { print ""; } ?>">
    </div>
    <?php if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>seguimientos/bajaLogica/<?php print $datos['data']['id']."/".$datos["pagina"]; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'seguimientos/seguimiento/'.$datos['idOrdenReparacion']."/".$datos['pagina']; ?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información.</b></p>
      <?php } else { ?>
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA.'seguimientos/seguimiento/'.$datos['idOrdenReparacion']."/".$datos['pagina']; ?>" class="btn btn-danger">Regresar</a>
      <?php } ?> 
  </form>
<?php include_once("piepagina.php"); ?>