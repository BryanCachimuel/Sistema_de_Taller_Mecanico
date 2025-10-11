<?php include_once("encabezado.php"); ?>
<form action="#" method="POST">
    <div class="form-group text-start">
        <label for="correo">* Correo:</label>
        <input id="correo" name="correo" type="email" class="form-control" placeholder="Escribe tu correo electrónico">
    </div>
    <div class="form-group text-start my-2">
        <input type="submit" value="Enviar" class="btn btn-success">
        <a href="login" class="btn btn-success">Regresar</a>
    </div>
</form>
<p>Escribe tu correo registrado en el sistema</p>
<?php include_once("piepagina.php"); ?>