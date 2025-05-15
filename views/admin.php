<?php
	if (session_status() === PHP_SESSION_NONE) {
			session_start();
	}
  if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
  }
  include '../config/database.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Administradores</title>
  <link rel="stylesheet" href="./../public/css/admin.css">
</head>
<body>

  <h2 class="pageTitle">Gestion de Administradores</h2>

  <div class="mainContainer">
    <div class="formContainer">
      <div class="headCard">
        <div class="titleCard">
          Agregar administrador
        </div>
        <div class="descCard">
          <div class="descInfo">
            Llene el siguiente formulario para dar de alta un administrador
          </div>
          <div class="stepCard">
            
          </div>
        </div>
      </div>
      <form action="../queries/addAdmin.php" method="post">
        <div class="rowInputs">
          <div class="labelAndInput">
            <div class="labelInput">
              Nombre
            </div>
            <input type="text" placeholder="Su nombre" name="nombre" class="inputInfo">
          </div>
          <div class="labelAndInput">
            <div class="labelInput">
              Usuario
            </div>
            <input type="text" placeholder="Nombre de usuario" name="usuario" class="inputInfo">
          </div>
        </div>
        <div class="rowInputs">
          <div class="labelAndInput">
            <div class="labelInput">
              Contraseña
            </div>
            <input type="password" placeholder="Su contraseña" name="password" class="inputInfo">
          </div>
          <div class="btnContainer">
            <button class="btnAdd">
              Agregar
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="tableContainer">
      <table class="customTable">
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $select = 'SELECT * FROM admin';
            $resultado = $conexion->query($select);
            if($resultado->num_rows > 0){
              while($admin = $resultado->fetch_assoc()){
                echo "<tr>";
                echo "<td class='infoTable'>" . $admin["adm_usuario"] . "</td>";
                echo "<td class='infoTable'>" . $admin["adm_nombre"] . "</td>";
                echo "<td>
                <form action='../queries/deleteAdmin.php' method='post'>
                  <input type='hidden' name='usuario' value=" . $admin['adm_usuario'] . ">
                  <button 
                    class='btnDelete'
                    data-id='{$admin['adm_usuario']}'>
                    Borrar
                  </button>
                </form>
                </td>";
                echo "</tr>";
              }
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>






</body>
</html>