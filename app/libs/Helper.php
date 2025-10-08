<?php

    class Helper {

        public static function mostrar($data, $detener=true):void {
            print "<pre>";
            var_dump($data);
            print "</pre>";
            if($detener) {
                exit();
            }
        }

    }

?>