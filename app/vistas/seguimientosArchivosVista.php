<?php include_once("encabezado.php"); ?>
<div class="table-responsive">
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th>Archivo</th>
                <th>Tamaño</th>
                <th>Foto</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 2; $i < count($datos['archivos']); $i++) {
                $carpeta = "fotos/" . $datos["data"]['idOrdenReparacion'] . "/" . $datos["data"]['id'] . "/";
                print "<tr>";
                print "<td class='text-start'>" . $datos["archivos"][$i] . "</td>";
                if (file_exists($carpeta)) {
                    print "<td class='text-start'>" . Helper::medidaSize(filesize($carpeta . $datos["archivos"][$i])) . "</td>";
                    print "<td class='text-start'><a href='" . RUTA . "seguimientos/mostrarImagen/" . $datos["data"]["id"] . "/" . $i . "'>";
                    print "<img src='" . RUTA . "public/" . $carpeta . $datos["archivos"][$i] . "' width='40'/></td>";
                    print "<td><a href='" . RUTA . "seguimientos/borrarImagen/" . $datos["data"]["id"] . "/" . $i . "' class='btn btn-danger'>Borrar imagen</a></td>";
                } else {
                    print "<td>Error en la</td>";
                    print "<td>lectura del</td>";
                    print "<td>archivo</td>";
                }
                print "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include_once("paginacion.php"); ?>
    <a href="<?php print RUTA . 'seguimientos/seguimiento/' . $datos["data"]['idOrdenReparacion'] . "/" . $datos["pagina"]; ?>" class="btn btn-success">
        Regresar</a>
    <?php include_once("piepagina.php"); ?>