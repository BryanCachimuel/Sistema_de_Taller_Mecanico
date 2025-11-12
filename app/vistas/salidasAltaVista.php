<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA; ?>vehiculos/alta/" method="POST">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="cliente-tab" data-bs-toggle="tab" href="#cliente" role="tab" aria-controls="cliente" aria-selected="true">Cliente</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="vehiculo-tab" data-bs-toggle="tab" href="#vehiculo" role="tab" aria-controls="vehiculo" aria-selected="false">Vehículo</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="materiales-tab" data-bs-toggle="tab" href="#materiales" role="tab" aria-controls="materiales" aria-selected="false">Materiales</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="manoobra-tab" data-bs-toggle="tab" href="#manoobra" role="tab" aria-controls="manoobra" aria-selected="false">Mano de obra</a>
    </li>
  </ul>
  <div class="tab-content" id="factura">
    <div class="tab-pane fade show active" id="cliente" role="tabpanel" aria-labelledby="cliente-tab">
      <p>* Si desea cambiar los datos, vaya a la sección correspondiente.</p>
      <div class="form-group text-left">
        <label for="nombres">Nombre del cliente:</label>
        <input type="text" name="nombres" id="nombres" class="form-control" value="<?php print isset($datos['data']['nombres'])?$datos['data']['nombres']:''; ?>" disabled>
      </div>
      <div class="form-group text-left">
      <label for="apellidos">Apellidos del cliente:</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control" value="<?php print isset($datos['data']['apellidos'])?$datos['data']['apellidos']:''; ?>" disabled>
      </div>

    <div class="form-group text-left">
      <label for="razonsocial">Razón Social:</label>
      <input type="text" name="razonsocial" id="razonsocial" class="form-control" value="<?php print isset($datos['data']['razonsocial'])?$datos['data']['razonsocial']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
      <label for="direccion">Dirección:</label>
      <input type="text" name="direccion" id="direccion" class="form-control" value="<?php print isset($datos['data']['direccion'])?$datos['data']['direccion']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
      <label for="correo">Correo electrónico:</label>
      <input type="text" name="correo" id="correo" class="form-control" value="<?php print isset($datos['data']['correo'])?$datos['data']['direccion']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
      <label for="telefono">Teléfono:</label>
      <input type="text" name="telefono" id="telefono" class="form-control" value="<?php print isset($datos['data']['telefono'])?$datos['data']['telefono']:''; ?>" disabled>
    </div>
    </div>

    <div class="tab-pane fade" id="vehiculo" role="tabpanel" aria-labelledby="vehiculo-tab">
      <div class="form-group text-left">
      <label for="marca">Marca del auto:</label>
      <input type="text" name="marca" id="marca" class="form-control" value="<?php print isset($datos['data']['marca'])?$datos['data']['marca']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
      <label for="modelo">* Modelo:</label>
      <input type="text" name="modelo" id="modelo" class="form-control" value="<?php print isset($datos['data']['modelo'])?$datos['data']['modelo']:''; ?>"  disabled>
    </div>

    <div class="form-group text-left">
      <label for="color">* Color:</label>
      <input type="text" name="color" id="color" class="form-control" value="<?php print isset($datos['data']['color'])?$datos['data']['color']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
      <label for="anio">Año:</label>
      <input type="text" name="anio" id="anio" class="form-control" value="<?php print isset($datos['data']['anio'])?$datos['data']['anio']:''; ?>" disabled>
    </div>

    <div class="form-group text-left">
      <label for="placas">Placas:</label>
      <input type="text" name="placas" id="placas" class="form-control" value="<?php print isset($datos['data']['placas'])?$datos['data']['placas']:''; ?>" disabled>
    </div>

    </div>
    <div class="tab-pane fade" id="materiales" role="tabpanel" aria-labelledby="materiales-tab">
    </div>
    <div class="tab-pane fade" id="manoobra" role="tabpanel" aria-labelledby="manoobra-tab">
    </div>
  </div>
    
    <div class="form-group text-start">
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