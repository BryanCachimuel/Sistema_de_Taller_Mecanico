<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>clientes/alta/" method="POST">

    <div class="form-group text-left mb-3">
      <label for="nombres">* <i class="fa-regular fa-address-card"></i> Nombres:</label>
      <input type="text" name="nombres" id="nombres" class="form-control" required value="<?php print isset($datos['data']['nombres'])?$datos['data']['nombres']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="apellidos">* <i class="fa-regular fa-address-card"></i> Apellidos:</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control" required value="<?php print isset($datos['data']['apellidos'])?$datos['data']['apellidos']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="razonSocial"><i class="fa-solid fa-id-card-clip"></i> Razon social:</label>
      <input type="text" name="razonSocial" id="razonSocial" class="form-control" value="<?php print isset($datos['data']['razonSocial'])?$datos['data']['razonSocial']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="direccion"><i class="fa-solid fa-location-crosshairs"></i> Dirección:</label>
      <input type="text" name="direccion" id="direccion" class="form-control" value="<?php print isset($datos['data']['direccion'])?$datos['data']['direccion']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="telefono"><i class="fa-solid fa-mobile-screen"></i> Teléfono:</label>
      <input type="text" name="telefono" id="telefono" class="form-control" value="<?php print isset($datos['data']['telefono'])?$datos['data']['telefono']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="rfc"><i class="fa-solid fa-id-card-clip"></i> Registro federal de contribuyente:</label>
      <input type="text" name="rfc" id="rfc" class="form-control" value="<?php print isset($datos['data']['rfc'])?$datos['data']['rfc']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="correo">* <i class="fa-regular fa-envelope"></i> Correo:</label>
      <input type="email" name="correo" id="correo" class="form-control" required value="<?php print isset($datos['data']['correo'])?$datos['data']['correo']:''; ?>" <?php if (isset($datos["baja"])) { print " disabled "; }?>>
    </div>

    <div class="form-group text-left mb-3">
      <label for="estado">* <i class="fa-solid fa-person-circle-check"></i> Estado del cliente:</label>
      <select class="form-control" name="estado" id="estado" 
      <?php if (isset($datos["baja"])) { print " disabled "; } ?>
      >
      <option value="void">---Selecciona un estado---</option>
        <?php
          for ($i=0; $i < count($datos["estadoCliente"]); $i++) { 
            print "<option value='".$datos["estadoCliente"][$i]["id"]."'";
              if(isset($datos["data"]["estado"]) && $datos["data"]["estado"]==$datos["estadoCliente"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["estadoCliente"][$i]["estado"]."</option>";
          } 
        ?>
      </select>
    </div>

    <div class="form-group text-start">
      <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
      <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">
      
      <?php if (isset($datos["baja"])) { ?>
        <a href="<?php print RUTA; ?>clientes/bajaLogica/<?php print $datos['data']['id']."/".$datos["pagina"]; ?>" class="btn btn-danger">Borrar</a>
        <a href="<?php print RUTA.'clientes/'.$datos['pagina']; ?>" class="btn btn-danger">Regresar</a>
        <p><b>Advertencia: una vez borrado el registro, no podrá recuperar la información.</b></p>
      <?php } else { ?>
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA; ?>clientes" class="btn btn-info">Regresar</a>
      <?php } ?> 
    </div>
  </form>
<?php include_once("piepagina.php"); ?>