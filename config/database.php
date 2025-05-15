<?php

  $servidor = 'localhost:3306';
  $usuario = 'root';
  $password = 'extssy55';
  $bd = 'inv_zapateria';

  // Conectar a la Base de Datos
  $conexion = new mysqli($servidor, $usuario, $password, $bd);
  if($conexion->connect_error){
    die('Conexion fallo '.$conexion->connect_error);
  }

?>
