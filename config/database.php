<?php

  $servidor = 'localhost:8889';
  $usuario = 'root';
  $password = 'root';
  $bd = 'inv_zapateria';

  // Conectar a la Base de Datos
  $conexion = new mysqli($servidor, $usuario, $password, $bd);
  if($conexion->connect_error){
    die('Conexion fallida '.$conexion->connect_error);
  }

?>
