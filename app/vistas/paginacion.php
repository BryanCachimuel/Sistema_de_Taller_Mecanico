<?php
  if (isset($datos["pag"])) {
    $totalPaginas = $datos["pag"]["totalPaginas"];
    $pagina = $datos["pag"]["pagina"];
    $regresa = $datos["pag"]["regresa"];
    if ($totalPaginas>1) {
      //
      print '<nav>';
      print ' <ul class="pagination justify-content-end">';
      if($totalPaginas > PAGINAS_MAXIMAS){

      } else {
        $inicio = 1;
        $fin = $totalPaginas;
      }
      for($i=$inicio; $i<=$fin; $i++){
        print '<li ';
        if($i==$pagina) {
          print 'class="page-item active"';
        } else {
          print 'class="page-item"';
        }
        print '>';
        print '<a class="page-link" href="'.RUTA.$regresa.'/'.$i.'">'.$i.'</a>';
        print '</li>';
      }
      print '</ul>';
      print '</nav>';
    }
  }
  ?>