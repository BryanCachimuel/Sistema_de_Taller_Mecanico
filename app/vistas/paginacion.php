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
        //pagina actual es la ultima
        if ($pagina==$totalPaginas) {
          $inicio = $pagina-PAGINAS_MAXIMAS;
          $fin = $totalPaginas;
        } else {
          $inicio = $pagina;
          $fin = $inicio-1 + PAGINAS_MAXIMAS;
        }
        if($fin>$totalPaginas){
          $inicio = $totalPaginas - PAGINAS_MAXIMAS + 1;
          $fin = $totalPaginas;
        }
        if ($inicio!=1) {
          print '<li class="page-item">';
          print '  <a class="page-link" href="'.RUTA.$regresa.'/'.($pagina-1);
          print '" tabindex="-1">&laquo;</a>';
          print '</li>';
        }
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
      if ($totalPaginas > PAGINAS_MAXIMAS && ($pagina+PAGINAS_MAXIMAS)<=$totalPaginas) {
        print '<li class="page-item">';
        print '  <a class="page-link" href="'.RUTA.$regresa.'/'.($pagina+1).'" tabindex="-1">&raquo;</a>';
        print '</li>';
      }
      print '</ul>';
      print '</nav>';
    }
  }
  ?>