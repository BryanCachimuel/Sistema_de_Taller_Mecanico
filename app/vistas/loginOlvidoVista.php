<?php include_once("encabezado.php"); ?>
<form action="<?php print RUTA; ?>login/olvido" method="POST">
	<div class="form-group text-start">
		<label for="correo">* <i class="fa-regular fa-envelope"></i> Correo:</label>
		<input id="correo" name="correo" type="text" class="form-control" placeholder="Escribe tu correo electrónico">
	</div>
	<div class="form-group text-start my-2">
		<input type="submit" value="Enviar" class="btn btn-success">
		<a href="<?php print RUTA; ?>login" class="btn btn-success"><i class="fa-solid fa-angles-left"></i> Regresar</a>
	</div>
</form>
<p><strong><i class="fa-solid fa-tags"></i> Nota: Escribe tu correo registrado en el sistema</strong></p>
<?php include_once("piepagina.php"); ?>					