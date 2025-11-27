<?php include_once("encabezado.php"); ?>
  <form action="<?php print RUTA.$datos["regreso"]; ?>/perfil/" method="POST">

    <div class="form-group text-left">
      <label for="nombres">* Nombres:</label>
      <input type="text" name="nombres" id="nombres" class="form-control" required value="<?php print isset($datos['data']['nombres'])?$datos['data']['nombres']:''; ?>">
    </div>

    <div class="form-group text-left">
      <label for="apellidos">* Apellidos:</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control" required value="<?php print isset($datos['data']['apellidos'])?$datos['data']['apellidos']:''; ?>">
    </div>
    <hr>
    <p>NOTA: si no desdea modificar su clave de acceso, verifique que los campos estén vacíos.</p>
    <div class="form-group text-left">
      <label for="clave">* Nueva clave de acceso:</label>
      <input type="password" name="clave" id="clave" class="form-control" placeholder="Escribe tu nueva clave de acceso" autocomplete="off">
    </div>
    <div class="form-group text-left">
      <label for="verifica">* Repite tu clave de acceso:</label>
      <input type="password" name="verifica" id="verifica" class="form-control" placeholder="Repite tu nueva clave de acceso" autocomplete="off">
    </div>

    <div class="form-group text-start">
      <input type="hidden" name="id" id="id" value="<?php print $datos['data']["id"]; ?>">
      <input type="submit" class="btn btn-success">
      <a href="<?php print RUTA.$datos['regreso']; ?>" class="btn btn-info">Regresar</a>
    </div>
  </form>
<?php include_once("piepagina.php"); ?>