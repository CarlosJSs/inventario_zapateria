<?php
  session_start();
  if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de inicio</title>
  <link rel="stylesheet" href="./../public/css/panel.css">
</head>
<body>
  <h2 class="pageTitle">Bienvenido al panel de inicio de su sistema.</h2>
</body>
</html>