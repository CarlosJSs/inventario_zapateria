<?php
  include '../config/database.php';

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $usuario = $_POST['usuario'];
    $sql_borrar = "DELETE FROM admin WHERE adm_usuario = ?";
    $result = $conexion->prepare($sql_borrar);
    $result->bind_param('s', $usuario);

    if($result->execute()){
      header('Location: ../views/layout.php?page=admin');
    }else{
      header('Location: ../views/layout.php?page=admin');
    }
  }
?>