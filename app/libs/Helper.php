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

        public static function encriptar(string $data): string {
            return base64_encode(LLAVE1.$data.LLAVE2);
        }

        public static function desencriptar(string $data):string {
            $cadena = base64_decode($data);
            if(str_contains($cadena, LLAVE1)){
                $cadena = str_replace(LLAVE1,"",$cadena);
                if(str_contains($cadena, LLAVE2)){
                    $cadena = str_replace(LLAVE2,"",$cadena);
                }else {
                    $cadena = "error";
                }
            }else {
                $cadena = "error";
            }
            return $cadena;
        }

    }

?>