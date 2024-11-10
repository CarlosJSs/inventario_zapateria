<?php
  interface IAdmin {
    public function crearAdmin($admin);
    public function actualizarAdmin($admin);
    public function borrarAdmin($usuario);
    public function obtenerAdmins();
  }
?>