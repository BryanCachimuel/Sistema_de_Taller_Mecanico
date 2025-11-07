<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>seguimientos/alta/" method="POST">

  <div class="form-group text-left">
    <label for="idVehiculo">* Vehículo:</label>
    <select class="form-control" name="idVehiculo" id="idVehiculo" 
    <?php if (isset($datos["baja"])) { print " disabled "; } ?>
    >
    <option value="void">---Selecciona un vehículo---</option>
      <?php
        for ($i=0; $i < count($datos["vehiculos"]); $i++) { 
          print "<option value='".$datos["vehiculos"][$i]["id"]."'";
            if(isset($datos["data"]["idVehiculo"]) && $datos["data"]["idVehiculo"]==$datos["vehiculos"][$i]["id"]){
              print " selected ";
            }
          print ">".$datos["vehiculos"][$i]["vehiculo"]."</option>";
        } 
      ?>
    </select>
  </div>

  <div class="form-group text-left">
    <label for="idMecanico">* Mecánico disponible:</label>
    <select class="form-control" name="idMecanico" id="idMecanico" 
    <?php if (isset($datos["baja"])) { print " disabled "; } ?>
    >
    <option value="void">---Selecciona un mecánico disponible---</option>
      <?php
        for ($i=0; $i < count($datos["mecanicos"]); $i++) { 
          print "<option value='".$datos["mecanicos"][$i]["id"]."'";
            if(isset($datos["data"]["idMecanico"]) && $datos["data"]["idMecanico"]==$datos["mecanicos"][$i]["id"]){
              print " selected ";
            }
          print ">".$datos["mecanicos"][$i]["mecanico"]."</option>";
        } 
      ?>
    </select>
  </div>

  <div class="form-group text-left">
    <label for="fechaIngreso">* Fecha de ingreso:</label>
    <input type="date" name="fechaIngreso" id="fechaIngreso" class="form-control" required value="<?php print isset($datos['data']['fechaIngreso'])?$datos['data']['fechaIngreso']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
  </div>

  <div class="form-group text-left">
    <label for="fechaSalida">* Fecha de salida:</label>
    <input type="date" name="fechaSalida" id="fechaSalida" class="form-control" required value="<?php print isset($datos['data']['fechaSalida'])?$datos['data']['fechaSalida']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
  </div>

  <div class="form-group text-left">
    <label for="kilometraje">* Kilometraje:</label>
    <input type="text" name="kilometraje" id="kilometraje" class="form-control" required value="<?php print isset($datos['data']['kilometraje'])?$datos['data']['kilometraje']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
  </div>

    <table width="100%">
      <tr>
        <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="gato" name="gato" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["gato"]) && $datos["data"]["gato"]) { print " checked "; };?>>
          <label class="form-check-label" for="gato">
          Gato
          </label>
        </div>
      </td>

      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="herramientas" name="herramientas" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["herramientas"]) && $datos["data"]["herramientas"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Herramientas
          </label>
        </div>
      </td>

      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="triangulos" name="triangulos" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["triangulos"]) && $datos["data"]["triangulos"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Triángulos
          </label>
        </div>
      </td>

      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="refaccion" name="refaccion" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["refaccion"]) && $datos["data"]["refaccion"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Llanta de refacción
          </label>
        </div>
      </td>
      </tr>

      <tr>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="extintor" name="extintor" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["extintor"]) && $datos["data"]["extintor"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Extintor
          </label>
        </div>
      </td>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="antena" name="antena" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["antena"])  && $datos["data"]["antena"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Antena
          </label>
        </div>
      </td>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="emblemas" name="emblemas" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["emblemas"]) && $datos["data"]["emblemas"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Emblemas
          </label>
        </div>
      </td>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="tapones" name="tapones" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["tapones"]) && $datos["data"]["tapones"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Tapones
          </label>
        </div>
      </td>
    </tr>

    <tr>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="cables" name="cables" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["cables"])  && $datos["data"]["cables"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Cables
          </label>
        </div>
      </td>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="estereo" name="estereo" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["estereo"]) && $datos["data"]["estereo"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Estereo
          </label>
        </div>
      </td>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="encendedor" name="encendedor" <?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["encendedor"]) && $datos["data"]["encendedor"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Encendedor
          </label>
        </div>
      </td>
      <td width="25%">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="tapetes" name="tapetes"<?php if (isset($datos["baja"])) { print " disabled "; }; if (isset($datos["data"]["tapetes"]) && $datos["data"]["tapetes"]) { print " checked "; };?>>
          <label class="form-check-label" for="flexCheckDefault">
          Tapetes
          </label>
        </div>
      </td>
    </tr>
    </table>

    <div class="form-group text-start">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">
      
      <?php if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>seguimientos/bajaLogica/<?php print $datos['data']['id']."/".$datos["pagina"]; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'seguimientos/'.$datos['pagina']; ?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información.</b></p>
      <?php } else { ?>
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>seguimientos" class="btn btn-info">Regresar</a>
      <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>