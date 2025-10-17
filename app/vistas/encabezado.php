<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <title>Taller | <?php print $datos["titulo"]; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a href="#" class="navbar-brand">Taller</a>
        <?php
        if (isset($datos["menu"]) && $datos["menu"] == true) {
            if (isset($datos["usuario"]["tipoUsuario"]) && $datos["usuario"]["tipoUsuario"] == ADMON) {
                print "<ul class='navbar-nav mr-auto mt-2 mt-lg-0'>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "salidas' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "salidas") print "active";
                print "'>Salidas</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "seguimientos' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "seguimientos") print "active";
                print "'>Seguimiento</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "ordenreparacion' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "ordenreparacion") print "active";
                print "'>Orden de reparación</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "ordenalmacen' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "ordenalmacen") print "active";
                print "'>Orden de almacén</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "vehiculos' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "vehiculos") print "active";
                print "'>Vehículos</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "clientes' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "clientes") print "active";
                print "'>Clientes</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "mecanicos' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "mecanicos") print "active";
                print "'>Mecánicos</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "usuarios' class='nav-link ";
                if (isset($datos["activo"]) && $datos["activo"] == "usuarios") print "active";
                print "'>Usuarios</a>";
                print "</li>";
                //
                print "<li class='nav-item'>";
                print "<a href='" . RUTA . "tablero/respaldar' class='nav-link'>Respaldar</a>";
                print "</li>";
                //
                print "</ul>";
                //
            }
            print "<ul class='nav navbar-nav ms-auto'>";
            //
            print "<li class='nav-item'>";
            print "<a href='" . RUTA . "tablero/perfil' class='nav-link'>";
            print '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
</svg>';
            print "</a>";
            print "</li>";

            print "<li class='nav-item'>";
            print "<a href='" . RUTA . "tablero/logout' class='nav-link'>";
            print '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg>';
            print "</a></li>";
            print "</ul>";
        }
        ?>
    </nav>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <?php
                if (isset($datos["errores"])) {
                    if (count($datos["errores"]) > 0) {
                        print "<div class='alert alert-danger mt-3'><ul>";
                        foreach ($datos["errores"] as $valor) {
                            print "<li>" . $valor . "</li>";
                        }
                        print "</ul></div>";
                    }
                }
                ?>
                <div class="card p-4 mt-3 bg-info-subtle">
                    <div class="card-header text-center">
                        <h2><?php print $datos["subtitulo"]; ?></h2>
                    </div>
                    <div class="card-body">