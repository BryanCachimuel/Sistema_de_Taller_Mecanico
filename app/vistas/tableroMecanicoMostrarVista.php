<?php include_once("encabezado.php"); ?>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Generales</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="accesorios-tab" data-bs-toggle="tab" href="#accesorios" role="tab" aria-controls="accesorios" aria-selected="false">Accesorios</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="piezas-tab" data-bs-toggle="tab" href="#piezas" role="tab" aria-controls="piezas" aria-selected="false">Materiales</a>
    </li>
</ul>
<div class="tab-content" id="ordenReparacion">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="form-group text-left">
            <label for="idVehiculo">* Vehículo:</label>
            <input type="text" name="idVehiculo" id="idVehiculo" class="form-control" value="<?php print isset($datos['data']['vehiculo']) ? $datos['data']['vehiculo'] : ''; ?>" disabled>
        </div>

        <div class="form-group text-left">
            <label for="idMecanico">* Mecánico:</label>
            <input type="text" name="idMecanico" id="idMecanico" class="form-control" value="<?php print isset($datos['data']['mecanico']) ? $datos['data']['mecanico'] : ''; ?>" disabled>
        </div>

        <div class="form-group text-left">
            <label for="fechaIngreso">* Fecha de ingreso:</label>
            <input type="date" name="fechaIngreso" id="fechaIngreso" class="form-control" value="<?php print isset($datos['data']['fechaIngreso']) ? $datos['data']['fechaIngreso'] : ''; ?>" disabled>
        </div>

        <div class="form-group text-left">
            <label for="fechaSalida">* Fecha de salida:</label>
            <input type="date" name="fechaSalida" id="fechaSalida" class="form-control" value="<?php print isset($datos['data']['fechaSalida']) ? $datos['data']['fechaSalida'] : ''; ?>" disabled>
        </div>

        <div class="form-group text-left">
            <label for="kilometraje">* Kilometraje:</label>
            <input type="text" name="kilometraje" id="kilometraje" class="form-control" required value="<?php print isset($datos['data']['kilometraje']) ? number_format($datos['data']['kilometraje'], 0) : ''; ?>" disabled>
        </div>

    </div>
    <div class="tab-pane fade" id="accesorios" role="tabpanel" aria-labelledby="accesorios-tab">
        <table width="100%">
            <tr>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="gato" name="gato" <?php if (isset($datos["data"]["gato"]) && $datos["data"]["gato"]) {
                                                                                                    print " checked ";
                                                                                                }; ?>disabled>
                        <label class="form-check-label" for="gato">
                            Gato
                        </label>
                    </div>
                </td>

                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="herramientas" name="herramientas" <?php if (isset($datos["data"]["herramientas"]) && $datos["data"]["herramientas"]) {
                                                                                                                    print " checked ";
                                                                                                                }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Herramientas
                        </label>
                    </div>
                </td>

                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="triangulos" name="triangulos" <?php if (isset($datos["data"]["triangulos"]) && $datos["data"]["triangulos"]) {
                                                                                                                print " checked ";
                                                                                                            }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Triángulos
                        </label>
                    </div>
                </td>

                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="refaccion" name="refaccion" <?php if (isset($datos["data"]["refaccion"]) && $datos["data"]["refaccion"]) {
                                                                                                            print " checked ";
                                                                                                        }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Llanta de refacción
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="extintor" name="extintor" <?php if (isset($datos["data"]["extintor"]) && $datos["data"]["extintor"]) {
                                                                                                            print " checked ";
                                                                                                        }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Extintor
                        </label>
                    </div>
                </td>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="antena" name="antena" <?php if (isset($datos["data"]["antena"])  && $datos["data"]["antena"]) {
                                                                                                        print " checked ";
                                                                                                    }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Antena
                        </label>
                    </div>
                </td>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="emblemas" name="emblemas" <?php if (isset($datos["data"]["emblemas"]) && $datos["data"]["emblemas"]) {
                                                                                                            print " checked ";
                                                                                                        }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Emblemas
                        </label>
                    </div>
                </td>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="tapones" name="tapones" <?php if (isset($datos["data"]["tapones"]) && $datos["data"]["tapones"]) {
                                                                                                        print " checked ";
                                                                                                    }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Tapones
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="cables" name="cables" <?php if (isset($datos["data"]["cables"])  && $datos["data"]["cables"]) {
                                                                                                        print " checked ";
                                                                                                    }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Cables
                        </label>
                    </div>
                </td>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="estereo" name="estereo" <?php if (isset($datos["data"]["estereo"]) && $datos["data"]["estereo"]) {
                                                                                                        print " checked ";
                                                                                                    }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Estereo
                        </label>
                    </div>
                </td>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="encendedor" name="encendedor" <?php if (isset($datos["data"]["encendedor"]) && $datos["data"]["encendedor"]) {
                                                                                                                print " checked ";
                                                                                                            }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Encendedor
                        </label>
                    </div>
                </td>
                <td width="25%">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="tapetes" name="tapetes" <?php if (isset($datos["data"]["tapetes"]) && $datos["data"]["tapetes"]) {
                                                                                                        print " checked ";
                                                                                                    }; ?> disabled>
                        <label class="form-check-label" for="flexCheckDefault">
                            Tapetes
                        </label>
                    </div>
                </td>
            </tr>
        </table>

    </div>
    <div class="tab-pane fade" id="piezas" role="tabpanel" aria-labelledby="piezas-tab">
        <?php
        if (count($datos['piezas']) > 0) {
            $total = 0;
            print "<table width='100%' class='table table-striped'><thead><tr><th>Pieza</th><th>Cantidad</th><th>Costo</th></tr></thead><tbody>";
            for ($i = 0; $i < count($datos['piezas']); $i++) {
                print "<tr><td>" . $datos['piezas'][$i]['nombrePieza'] . "</td>";
                print "<td>" . $datos['piezas'][$i]['cantidad'] . "</td>";
                print "<td>" . number_format($datos['piezas'][$i]['costo'], 2) . "</td></tr>";
                $total += $datos['piezas'][$i]['costo'];
            }
            print "</tbody><tfoot>";
            print "<tr class='table-dark'><td>&nbsp;</td>";
            print "<td>&nbsp;</td>";
            print "<td>" . number_format($total, 2) . "</td></tr>";
            print "</tfoot>";
            print "</table>";
        } else {
            print "<h2>No hay piezas asignadas a esta órden de reparación.</h2>";
        }
        ?>
    </div>

</div>
<div class="form-group text-start">
    <input type="hidden" name="id" id="id" value="<?php if (isset($datos['data']['id'])) {
                                                        print $datos['data']['id'];
                                                    } else {
                                                        print "";
                                                    } ?>">
    <input type="hidden" name="pagina" id="pagina" value="<?php if (isset($datos['pagina'])) {
                                                                print $datos['pagina'];
                                                            } else {
                                                                print "1";
                                                            } ?>">
    <a href="<?php print RUTA; ?>tableroMecanico" class="btn btn-info">Regresar</a>
</div>
<?php include_once("piepagina.php"); ?>