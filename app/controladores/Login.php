<?php

class Login extends Controlador
{
    private $modelo = "";
    private $sesion;

    function __construct()
    {
        $this->modelo = $this->modelo("LoginModelo");
    }

    public function caratula()
    {
        $datos = [
            "titulo" => "Login",
            "subtitulo" => "Taller mecánico"
        ];
        $this->vista("loginCaratulaVista", $datos);
    }

    public function olvido()
    {
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $correo = $_POST['correo'] ?? "";
            if (empty($correo)) {
                array_push($errores, "El correo electrónico es requerido.");
            }
            if (filter_var($correo, FILTER_VALIDATE_EMAIL) == false) {
                array_push($errores, "El correo electrónico no está bien escrito.");
            }
            if (empty($errores)) {
                $data = $this->modelo->buscarCorreo($correo);
                if (!$this->enviarCorreo($data)) {
                    $this->mensaje(
                        "Cambio de clave de acceso",
                        "Cambio de clave de acceso",
                        "Se ha enviado un correo a <b>" . $data["correo"] . "</b> para que puedas cambiar tu clave de acceso. Cualquier duda te puedes comunicar con nosotros. No olvides revisar tu bandeja de spam.",
                        "login",
                        "warning"
                    );
                } else {
                    array_push($errores, "Error al enviar el correo electrónico.");
                }
            }
        }
        $datos = [
            "titulo" => "Olvido de la clave de acceso",
            "subtitulo" => "Olvidaste tu clave de accesso",
            "errores" => $errores
        ];
        $this->vista("loginOlvidoVista", $datos);
    }

    public function enviarCorreo(array $data = []): bool
    {
        $salida = false;
        if (!empty($data)) {
            $id = Helper::encriptar($data["id"]);
            //
            $msg = "Entra en el siguiente enlace para cambiar tu clave de acceso al sistema de control de mi taller mecánico...<br>";
            $msg .= "<a href='" . RUTA . "login/cambiarclave/" . $id . "'>Cambiar tu clave de acceso</a>";

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type:text/html; charset=UTF-8\r\n";
            $headers .= "From: Taller Mecanico\r\n";
            $headers .= "Reply-to: ayuda@taller.com\r\n";

            $asunto = "Cambiar clave de acceso";
            Helper::mostrar($msg);
            //$salida = @mail($data["correo"],$asunto,$msg, $headers);
        }
        return $salida;
    }

    public function cambiarClave(string $id = ''): void
    {
        $id = Helper::desencriptar($id);
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $clave1 = $_POST['clave'] ?? "";
            $clave2 = $_POST['verifica'] ?? "";
            $id = $_POST['id'] ?? "";
            //
            if (empty($clave1)) {
                array_push($errores, "La clave de acceso es requerida.");
            }
            if (empty($clave2)) {
                array_push($errores, "La clave de acceso de verificación es requerida.");
            }
            if ($clave1 != $clave2) {
                array_push($errores, "Las claves de acceso no coinciden.");
            }
            //
            if (count($errores) == 0) {
                $clave = hash_hmac("sha512", $clave1, CLAVE);
                $data = ["clave" => $clave, "id" => $id];
                if ($this->modelo->actualizarClaveAcceso($data)) {
                    $this->mensaje(
                        "Cambio de clave de acceso",
                        "Cambio de clave de acceso",
                        "La clave de acceso se modificó correctamente.",
                        "login",
                        "success"
                    );
                } else {
                    $this->mensaje(
                        "Cambio de clave de acceso",
                        "Cambio de clave de acceso",
                        "Existió un error al actualizar la clave de acceso. Favor de intentarlo más tarde o reportarlo a soporte técnico.",
                        "login",
                        "danger"
                    );
                }
            }
        } else if ($id == "error") {
            $this->mensaje(
                "Cambio de clave de acceso",
                "Cambio de clave de acceso",
                "Error al mandar desencriptar. Favor de intentarlo más tarde.",
                "login",
                "danger"
            );
        }
        $datos = [
            "titulo" => "Cambiar contraseña",
            "subtitulo" => "Cambiar contraseña",
            "errores" => $errores,
            "data" => $id
        ];
        $this->vista("loginCambiarVista", $datos);
    }

    public function verificar()
    {
        $errores = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"] ?? "";
            $usuario = $_POST['usuario'] ?? "";
            $clave = $_POST['clave'] ?? "";
            //
            if (empty($clave)) {
                array_push($errores, "La clave de acceso es requerida.");
            }
            if (empty($usuario)) {
                array_push($errores, "El usuario es requerido.");
            }
            if (count($errores) == 0) {
                $clave = hash_hmac("sha512", $clave, CLAVE);
                $data = $this->modelo->buscarCorreo($usuario);
                if ($data && $data["clave"] == $clave) {
                    $this->sesion = new Sesion();
                    $this->sesion->iniciarLogin($data);
                    header("location:".RUTA."Tablero");
                }
                $this->mensaje(
                    "Sistema de taller mecánico",
                    "Sistema de taller mecánico",
                    "Existió un error al entrar al sistema. Favor de intentarlo nuevamente.",
                    "login",
                    "danger"
                );
            }
        }
    }
}
