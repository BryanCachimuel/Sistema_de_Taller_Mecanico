<?php include("encabezado.php"); ?>
	<form action="<?php print RUTA; ?>login/cambiarClave" method="POST">
		<div class="form-group text-left">
			<label for="clave">* Nueva clave de acceso:</label>
			<input type="password" name="clave" class="form-control" placeholder="Escribe tu Nueva clave de acceso." required>
		</div>
		<div class="form-group text-left">
			<label for="verifica">* Repite tu clave de acceso:</label>
			<input type="password" name="verifica" class="form-control" placeholder="Repite tu nueva clave de acceso." required>
		</div>
		<div class="form-group text-left mt-2">
			<input type="submit" value="Enviar" class="btn btn-success">
			<input type="hidden" name="id" id="id" value="<?php print $datos['data']; ?>">
		</div>
	</form>
<?php include("piepagina.php"); ?>