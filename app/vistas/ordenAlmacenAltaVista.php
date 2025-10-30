<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>ordenAlmacen/altaOrdenAlmacenDetalle/" method="POST">

  <div class="form-group text-left">
    <label for="idOrdenReparacion">* Orden reparación:</label>
    <select class="form-control" name="idOrdenReparacion" id="idOrdenReparacion" 
    <?php if (isset($datos["baja"])) { print " disabled "; } ?>
    >
    <option value="void">---Selecciona una orden de reparación---</option>
      <?php
        for ($i=0; $i < count($datos["ordenesReparacion"]); $i++) { 
          print "<option value='".$datos["ordenesReparacion"][$i]["id"]."'";
            if(isset($datos["data"]["idOrdenReparacion"]) && $datos["data"]["idOrdenReparacion"]==$datos["ordenesReparacion"][$i]["id"]){
              print " selected ";
            }
          print ">".$datos["ordenesReparacion"][$i]["auto"]."</option>";
        } 
      ?>
    </select>
  </div>

  <div class="form-group text-left">
    <label for="observacion">Observación:</label>
    <textarea class="form-control" id="observacion" name="observacion" rows="3" ></textarea>
  </div>

    <div class="form-group text-start">
      <input type="hidden" name="idOrdenAlmacen" id="id" value="<?php if (isset($datos['data']['idOrdenAlmacen'])) { print $datos['data']['idOrdenAlmacen']; } else { print ""; } ?>">
      <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">
      <input type="submit" value="Enviar" class="btn btn-success mt-3">
      <a href="<?php print RUTA; ?>ordenAlmacen" class="btn btn-info mt-3">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>