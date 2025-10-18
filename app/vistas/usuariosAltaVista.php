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
		<input id="nombres" name="nombres" type="text" class="form-control" placeholder="Nombre del usuario" required>
	</div>

	<div class="form-group text-start">
		<label for="direccion">Dirección:</label>
		<input id="direccion" name="direccion" type="text" class="form-control" placeholder="Dirección del usuario">
	</div>

	<div class="form-group text-start">
		<label for="telefono">* Telefono del usuario:</label>
		<input id="telefono" name="telefono" type="text" class="form-control" placeholder="Teléfono del usuario" required>
	</div>

	<div class="form-group text-start">
		<label for="correo">* Correo del usuario:</label>
		<input id="correo" name="correo" type="text" class="form-control" placeholder="Correo del usuario" required>
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

	<div class="form-group text-start">
	  <label for="estadoUsuario">* Estado del usuario:</label>
      <select class="form-control" name="estadoUsuario" id="estadoUsuario">
      <option value="void">---Selecciona el estado del usuario---</option>
        <?php
          for ($i=0; $i < count($datos["estadosUsuarios"]); $i++) { 
            print "<option value='".$datos["estadosUsuarios"][$i]["id"]."'";
              if(isset($datos["data"]["estado"]) && $datos["data"]["estado"]==$datos["estadosUsuarios"][$i]["id"]){
                print " selected ";
              }
            print ">".$datos["estadosUsuarios"][$i]["estado"]."</option>";
          } 
        ?>
      </select>
	</div>

	<div class="form-group text-start my-2">
		<input type="submit" value="Enviar" class="btn btn-success">
		<a href="<?php print RUTA; ?>usuarios" class="btn btn-success">Regresar</a>
	</div>
</form>
<?php include_once("piepagina.php"); ?>					