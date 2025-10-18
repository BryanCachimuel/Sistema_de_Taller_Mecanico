<?php include_once("encabezado.php"); ?>
<form action="<?php print RUTA; ?>usuarios/alta" method="POST">
    <div class="form-group text-start">
        <label for="tipoUsuario">* Tipo de usuario:</label>
        <input id="tipoUsuario" name="tipoUsuario" type="text" class="form-control" placeholder="">
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
        <input id="genero" name="genero" type="text" class="form-control" placeholder="Género del usuario" required>
    </div>

    <div class="form-group text-start">
        <label for="estadoUsuario">* Género del usuario:</label>
        <input id="estadoUsuario" name="estadoUsuario" type="text" class="form-control" placeholder="Género del usuario" required>
    </div>

    <div class="form-group text-start my-2">
        <input type="submit" value="Enviar" class="btn btn-success">
        <a href="<?php print RUTA; ?>usuarios" class="btn btn-success">Regresar</a>
    </div>
</form>
<?php include_once("piepagina.php"); ?>