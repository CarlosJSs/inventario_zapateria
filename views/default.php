<?php
	if (session_status() === PHP_SESSION_NONE) {
			session_start();
	}
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
</head>
<body>
  <h2>Pagina por deafult</h2>
</body>
</html>