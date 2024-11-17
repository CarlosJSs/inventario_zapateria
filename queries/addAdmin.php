<?php
  include '../config/database.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql_usuario = "SELECT * FROM admin WHERE adm_usuario = ?";
    $result = $conexion->prepare($sql_usuario);
    $result->bind_param('s', $usuario);
    $result->execute();

    $exist = $result->get_result();
    if($exist->num_rows > 0){
      header('Location: ../views/layout.php?page=admin');
    }

    $sql_insertar = "INSERT INTO admin (adm_usuario, adm_contra, adm_nombre) VALUES(?,?,?)";
    $insertar = $conexion->prepare($sql_insertar);
    $insertar->bind_param('sss', $usuario, $password, $nombre);
    if($insertar->execute()){
      header('Location: ../views/layout.php?page=admin');
    }else{
      header('Location: ../views/layout.php?page=admin');
    }
  }
?>