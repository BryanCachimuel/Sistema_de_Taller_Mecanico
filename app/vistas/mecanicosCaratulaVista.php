<?php include_once("encabezado.php"); ?>
<div class="table-responsive">
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Modificar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($datos['data']); $i++) {
                print "<tr>";
                print "<td class='text-start'>" . $datos["data"][$i]['id'] . "</td>";
                print "<td class='text-start'>" . $datos["data"][$i]['nombre'] . "</td>";
                print "<td class='text-start'>" . $datos["data"][$i]['tipo'] . "</td>";
                print "<td class='text-start'>" . $datos["data"][$i]['estado'] . "</td>";
                print "<td><a href='" . RUTA . "mecanicos/modificar/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-info'>Modificar</a></td>";
                print "<td><a href='" . RUTA . "mecanicos/borrar/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-danger'>Borrar</a></td>";
                print "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include_once("paginacion.php"); ?> 
    <a href="<?php print RUTA; ?>mecanicos/alta" class="btn btn-success">
        Dar de alta un Mecánicos</a>
    <?php include_once("piepagina.php"); ?>