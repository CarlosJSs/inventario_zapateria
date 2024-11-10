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
  <title>Document</title>
  <link rel="stylesheet" href="../public/css/entradas.css">
</head>
<body>
  <h2>Estas en entradas</h2>
</body>
</html>