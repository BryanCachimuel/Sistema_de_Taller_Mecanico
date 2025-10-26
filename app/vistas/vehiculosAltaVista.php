<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>vehiculos/alta/" method="POST">

    <div class="form-group text-left">
      <label for="marca">* Marca:</label>
      <input type="text" name="marca" id="marca" class="form-control" required value="<?php print isset($datos['data']['marca'])?$datos['data']['marca']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="modelo">* Modelo:</label>
      <input type="text" name="modelo" id="modelo" class="form-control" required value="<?php print isset($datos['data']['modelo'])?$datos['data']['modelo']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="color">* Color:</label>
      <input type="text" name="color" id="color" class="form-control" value="<?php print isset($datos['data']['color'])?$datos['data']['color']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?> required>
    </div>

    <div class="form-group text-left">
      <label for="anio">Año:</label>
      <input type="text" name="anio" id="anio" class="form-control" value="<?php print isset($datos['data']['anio'])?$datos['data']['anio']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="placas">Placas:</label>
      <input type="text" name="placas" id="placas" class="form-control" value="<?php print isset($datos['data']['placas'])?$datos['data']['placas']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="cliente">* Cliente:</label>
      <select class="form-control" name="cliente" id="cliente" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona un cliente---</option>
        <?php
          for ($i=0; $i < count($datos["clientes"]); $i++) { 
            print "<option value='".$datos["clientes"][$i]["id"]."'";
              if(isset($datos["data"]["idCliente"]) && $datos["data"]["idCliente"]==$datos["clientes"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["clientes"][$i]["cliente"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-start mt-3">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">
      
      <?php if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>vehiculos/bajaLogica/<?php print $datos['data']['id']."/".$datos["pagina"]; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'vehiculos/'.$datos['pagina']; ?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información.</b></p>
      <?php } else { ?>
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>vehiculos" class="btn btn-info">Regresar</a>
      <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>