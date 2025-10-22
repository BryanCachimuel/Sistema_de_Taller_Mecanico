<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>mecanicos/alta/" method="POST">

    <div class="form-group text-left">
      <label for="nombres">* Nombres:</label>
      <input type="text" name="nombres" id="nombres" class="form-control" required value="<?php print isset($datos['data']['nombres'])?$datos['data']['nombres']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="apellidos">* Apellidos:</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control" required value="<?php print isset($datos['data']['apellidos'])?$datos['data']['apellidos']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="telefono">Teléfono:</label>
      <input type="text" name="telefono" id="telefono" class="form-control" value="<?php print isset($datos['data']['telefono'])?$datos['data']['telefono']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="correo">* Correo:</label>
      <input type="email" name="correo" id="correo" class="form-control" required value="<?php print isset($datos['data']['correo'])?$datos['data']['correo']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left">
      <label for="tipoMecanico">* Tipo de mecánico:</label>
      <select class="form-control" name="tipoMecanico" id="tipoMecanico" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona un tipo de mecánico---</option>
        <?php
          for ($i=0; $i < count($datos["tipoMecanico"]); $i++) { 
            print "<option value='".$datos["tipoMecanico"][$i]["id"]."'";
              if(isset($datos["data"]["tipoMecanico"]) && $datos["data"]["tipoMecanico"]==$datos["tipoMecanico"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["tipoMecanico"][$i]["tipo"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-left">
      <label for="estado">* Estado del mecánico:</label>
      <select class="form-control" name="estado" id="estado" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona un estado---</option>
        <?php
          for ($i=0; $i < count($datos["estadoMecanico"]); $i++) { 
            print "<option value='".$datos["estadoMecanico"][$i]["id"]."'";
              if(isset($datos["data"]["estado"]) && $datos["data"]["estado"]==$datos["estadoMecanico"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["estadoMecanico"][$i]["estado"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-start mt-4">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">
      
      <?php if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>mecanicos/bajaLogica/<?php print $datos['data']['id']."/".$datos["pagina"]; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'mecanicos/'.$datos['pagina']; ?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información</b></p>
      <?php } else { ?>
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>mecanicos" class="btn btn-info">Regresar</a>
      <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>