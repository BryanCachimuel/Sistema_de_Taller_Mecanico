<?php include_once("encabezado.php"); ?>
<div class="table-responsive">
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Razón Social</th>
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
                print "<td class='text-start'>" . $datos["data"][$i]['razonSocial'] . "</td>";
                print "<td class='text-start'>" . $datos["data"][$i]['estado'] . "</td>";
                print "<td><a href='" . RUTA . "clientes/modificar/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-info'>Modificar</a></td>";
                print "<td><a href='" . RUTA . "clientes/borrar/" . $datos["data"][$i]["id"] . "/" . $datos["pag"]["pagina"] . "' class='btn btn-danger'>Borrar</a></td>";
                print "</tr>";
            }
            ?>
        </tbody>
    </table>
    <?php include_once("paginacion.php"); ?>
    <a href="<?php print RUTA; ?>clientes/alta" class="btn btn-success">
        Dar de alta un Cliente</a>
    <?php include_once("piepagina.php"); ?>