<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
	<title></title>
</head>

<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<a href="#" class="navbar-brand">Taller</a>
	</nav>
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<div class="card p-4 mt-3 bg-light">
					<div class="card-header text-center">
						<h2>Taller mecánico</h2>
					</div>
					<div class="card-body">
						<form action="#" method="POST">
							<div class="form-group text-start">
								<label for="usuario">* Usuario:</label>
								<input id="usuario" name="usuario" type="text" class="form-control" placeholder="Escribe tu usuario (correo electrónico)">
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
						<a href="#">¿Olvidaste tu clave de acceso?</a><br>
					</div>
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
</body>

</html>