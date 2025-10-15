<?php include_once("encabezado.php"); ?>
						<form action="#" method="POST">
							<div class="form-group text-start">
								<label for="usuario">* Usuario:</label>
								<input id="usuario" name="usuario" type="email" class="form-control" placeholder="Escribe tu usuario (correo electrónico)" required>
							</div>
							<div class="form-group text-start">
								<label for="clave">* Clave de acceso:</label>
								<input id="clave" name="clave" type="password" class="form-control" placeholder="Escribe tu clave de acceso">
							</div>
							<div class="form-group text-start mt-2">
								<input type="checkbox" name="recordar">
								<label for="recordar">Recordar</label>
							</div>
							<div class="form-group text-start my-2">
								<input type="submit" value="Iniciar Sesión" class="btn btn-success">
							</div>
						</form>
						<a href="/taller/login/olvido">¿Olvidaste tu clave de acceso?</a><br>
<?php include_once("piepagina.php"); ?>