<?php include_once("encabezado.php"); ?>
<form action="<?php print RUTA; ?>usuarios/alta" method="POST">
	<div class="form-group text-start">
		<label for="tipoUsuario">* Tipo de usuario:</label>
      <select class="form-control" name="tipoUsuario" id="tipoUsuario">
      <option value="void">---Selecciona un tipo de usuario---</option>
        <?php
          for ($i=0; $i < count($datos["tiposUsuarios"]); $i++) { 
            print "<option value='".$datos["tiposUsuarios"][$i]["id"]."'";
              if(isset($datos["data"]["tipoUsuario"]) && $datos["data"]["tipoUsuario"]==$datos["tiposUsuarios"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["tiposUsuarios"][$i]["tipoUsuario"]."</option>";
          } 
        ?>
      </select>
	</div>

	<div class="form-group text-start">
		<label for="nombres">* Nombre del usuario:</label>
		<input id="nombres" name="nombres" type="text" class="form-control" placeholder="Nombre del usuario" required value="<?php print isset($datos['data']['nombres'])?$datos['data']['nombres']:''; ?>">
	</div>

	<div class="form-group text-start">
		<label for="apellidos">* Apellidos del usuario:</label>
		<input id="apellidos" name="apellidos" type="text" class="form-control" placeholder="Apellidos del usuario" required value="<?php print isset($datos['data']['apellidos'])?$datos['data']['apellidos']:''; ?>">
	</div>

	<div class="form-group text-start">
		<label for="direccion">Dirección:</label>
		<input id="direccion" name="direccion" type="text" class="form-control" placeholder="Dirección del usuario" value="<?php print isset($datos['data']['direccion'])?$datos['data']['direccion']:''; ?>">
	</div>

	<div class="form-group text-start">
		<label for="telefono">* Telefono del usuario:</label>
		<input id="telefono" name="telefono" type="text" class="form-control" placeholder="Teléfono del usuario" required  value="<?php print isset($datos['data']['telefono'])?$datos['data']['telefono']:''; ?>">
	</div>

	<div class="form-group text-start">
		<label for="correo">* Correo del usuario:</label>
		<input id="correo" name="correo" type="text" class="form-control" placeholder="Correo del usuario" required value="<?php print isset($datos['data']['correo'])?$datos['data']['correo']:''; ?>">
	</div>

	<div class="form-group text-start">
	  <label for="genero">* Género del usuario:</label>
      <select class="form-control" name="genero" id="genero">
      <option value="void">---Selecciona un género---</option>
        <?php
          for ($i=0; $i < count($datos["generos"]); $i++) { 
            print "<option value='".$datos["generos"][$i]["id"]."'";
              if(isset($datos["data"]["genero"]) && $datos["data"]["genero"]==$datos["generos"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["generos"][$i]["genero"]."</option>";
          } 
        ?>
      </select>
	</div>

	<div class="form-group text-start my-2">
		<input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">
		<input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">
      
		<input type="submit" value="Enviar" class="btn btn-success">
		<a href="<?php print RUTA; ?>usuarios" class="btn btn-success">Regresar</a>
	</div>
</form>
<?php include_once("piepagina.php"); ?>					