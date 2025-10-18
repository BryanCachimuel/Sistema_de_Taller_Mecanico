<?php

    class UsuariosModelo {

        // llamando a la conexión hacia la bdd
        private $db = "";

        function __construct() {
            $this->db = new MySQLdb();
        }

        public function getTabla() {
            $sql = "SELECT u.id, CONCAT(u.apellidos,' ',u.nombres) as nombre, ";
            $sql.= "tu.tipoUsuario, eu.estado ";
            $sql.= "FROM usuarios as u, tipoUsuario as tu, estadoUsuario as eu ";
            $sql.= "WHERE u.baja=0 AND ";
            $sql.= "u.estadoUsuario = eu.id AND ";
            $sql.= "u.tipoUsuario=tu.id";
            return $this->db->querySelect($sql);
        }

        public function getTipoUsuarios() {
            $sql = "SELECT id, tipoUsuario FROM tipoUsuario";
            return $this->db->querySelect($sql);
        }

        public function getEstadosUsuarios() {
            $sql = "SELECT id, estado FROM estadoUsuario";
            return $this->db->querySelect($sql);
        }
    }

?>