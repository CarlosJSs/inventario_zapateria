<?php

$host = 'localhost';  
$port = '8889';          
$dbname = 'inv_zapateria';  
$username = 'root';       
$password = 'root';       

$conexion = new mysqli($host, $username, $password, $dbname, $port);

if($conexion->connect_error){
    die('Conexión fallida: ' . $conexion->connect_error);
} else {
    echo "Conexión exitosa";
}
?>

