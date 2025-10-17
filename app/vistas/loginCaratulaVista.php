<?php include_once("encabezado.php"); ?>
	<form action="<?php print RUTA; ?>login/verificar" method="POST">
		<div class="form-group text-start">
			<label for="usuario">* Usuario:</label>
			<input id="usuario" name="usuario" type="email" class="form-control" placeholder="Escribe tu usuario (correo electrónico)" value="<?php print isset($datos['data']['usuario'])?$datos['data']['usuario']:''; ?>" required>
		</div>
		<div class="form-group text-start">
			<label for="clave">* Clave de acceso:</label>
			<input id="clave" name="clave" type="password" class="form-control" placeholder="Escribe tu clave de acceso" value="<?php print isset($datos['data']['clave'])?$datos['data']['clave']:''; ?>" required>
		</div>
		<div class="form-group text-start mt-2">
			<input type="checkbox" name="recordar" <?php print isset($datos['data']['usuario'])?'checked':''; ?> >
			<label for="recordar">Recordar</label>
		</div>
		<div class="form-group text-start mt-2">
			<input type="submit" value="Enviar" class="btn btn-success">
		</div>
		<a href="<?php print RUTA; ?>login/olvidoVerificar">¿Olvidaste tu clave de acceso?</a><br>
	</form>
<?php include_once("piepagina.php"); ?>				