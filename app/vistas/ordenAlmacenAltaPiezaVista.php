<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>ordenAlmacen/altaOrdenAlmacenPieza/" method="POST">
  <div class="form-group text-left">
    <label for="idPieza">* Pieza:</label>
    <select class="form-control" name="idPieza" id="idPieza" 
    <?php if (isset($datos["baja"])) { print " disabled "; } ?>
    >
    <option value="void">---Selecciona una pieza---</option>
      <?php
        for ($i=0; $i < count($datos["piezas"]); $i++) { 
          print "<option value='".$datos["piezas"][$i]["id"]."'";
            if(isset($datos["data"]["idPieza"]) && $datos["data"]["idPieza"]==$datos["piezas"][$i]["id"]){
              print " selected ";
            }
          print ">".$datos["piezas"][$i]["nombrePieza"]."</option>";
        } 
      ?>
    </select>
  </div>

  <div class="form-group text-left">
      <label for="cantidad">* Cantidad:</label>
      <input type="text" name="cantidad" id="cantidad" class="form-control" required value="<?php print isset($datos['data']['cantidad'])?$datos['data']['cantidad']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
  </div>

  <div class="form-group text-start">
    <input type="hidden" name="idOrdenAlmacen" id="idOrdenAlmacen" value="<?php if (isset($datos['idOrdenAlmacen'])) { print $datos['idOrdenAlmacen']; } else { print ""; } ?>">
    <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pag'])) { print $datos['pag']; } else { print "1"; } ?>">

      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>ordenalmacen" class="btn btn-info">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>