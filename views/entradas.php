<?php
if (session_status() === PHP_SESSION_NONE) {
        session_start();
}
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php'; 

// Habilitar la visualización de errores de PHP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Insertar datos en la tabla 'entrada'
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prov_id = $_POST['prov_id'];
    $prod_id = $_POST['prod_id'];
    $fecha = $_POST['fecha']; 
    $costo = $_POST['costo'];
    $cantidad = $_POST['cantidad'];

    // Obtener la hora actual
    date_default_timezone_set('America/Mexico_City');
    $hora_actual = date('H:i:s');
    
    // Combinar fecha y hora
    $fecha_con_hora = $fecha . ' ' . $hora_actual;

    // Preparar la consulta para evitar inyección SQL
    $stmt = $conexion->prepare("INSERT INTO entrada (ent_prov, ent_fecha, ent_costo, ent_prod_id, ent_cantidad) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $prov_id, $fecha_con_hora, $costo, $prod_id, $cantidad);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Obtener datos de la tabla 'entrada'
$sql_entradas = "SELECT e.ent_id, p.prov_nombre, e.ent_fecha, e.ent_costo, e.ent_cantidad, prod.prod_nombre
                    FROM entrada e
                    JOIN proveedor p ON e.ent_prov = p.prov_id
                    JOIN producto prod ON e.ent_prod_id = prod.prod_id";
$result_entradas = $conexion->query($sql_entradas);


// Obtener proveedores
$sql_proveedores = "SELECT prov_id, prov_nombre FROM proveedor";
$result_proveedores = $conexion->query($sql_proveedores);

// Obtener productos
$sql_productos = "SELECT prod_id, prod_nombre FROM producto";
$result_productos = $conexion->query($sql_productos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Entradas</title>
    <link rel="stylesheet" href="./../public/css/entradas.css">
</head>
<body>
    <h2 class="title">Gestión de Entradas</h2>
    <div class="container-flex">
        <div class="modal">
            <h1>Agregar nueva entrada</h1>
            <form method="POST" action="" class="form">
                <div class="input_container">
                    <label for="prov_id" class="input_label">Proveedor:</label>
                    <select name="prov_id" id="prov_id" class="input_field" required>
                        <?php
                        // Mostrar proveedores desde la base de datos
                        if ($result_proveedores->num_rows > 0) {
                            while ($row = $result_proveedores->fetch_assoc()) {
                                echo "<option value='" . $row['prov_id'] . "'>" . $row['prov_nombre'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay proveedores disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input_container">
                    <label for="prod_id" class="input_label">Producto:</label>
                    <select name="prod_id" id="prod_id" class="input_field" required>
                        <?php
                        // Mostrar productos desde la base de datos
                        if ($result_productos->num_rows > 0) {
                            while ($row = $result_productos->fetch_assoc()) {
                                echo "<option value='" . $row['prod_id'] . "'>" . $row['prod_nombre'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay productos disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input_container">
                    <label for="fecha" class="input_label">Fecha:</label>
                    <input type="date" name="fecha" id="fecha" class="input_field" required>
                </div>

                <div class="input_container">
                    <label for="costo" class="input_label">Costo:</label>
                    <input type="number" name="costo" id="costo" class="input_field" step="0.01" required>
                </div>

                <div class="input_container">
                    <label for="cantidad" class="input_label">Cantidad:</label>
                    <input type="number" name="cantidad" id="cantidad" class="input_field" required>
                </div>

                <button type="submit" class="purchase--btn">Guardar Entrada</button>
            </form>
        </div>
    </div>

    <div class="container-flex">
        <div class="modal-table">
            <h2>Entradas Registradas</h2>
            <table>
    <tr>
        <th>ID</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        <th>Costo</th>
        <th>Cantidad</th>
        <th>Producto</th>
    </tr>
    <?php
    if ($result_entradas->num_rows > 0) {
        while($row = $result_entradas->fetch_assoc()) {
            // Formatear la fecha
            $fecha_formateada = date('d/m/Y H:i:s', strtotime($row['ent_fecha']));
            
            echo "<tr>
                    <td>" . $row['ent_id'] . "</td>
                    <td>" . $row['prov_nombre'] . "</td>  <!-- Mostrar nombre del proveedor -->
                    <td>" . $fecha_formateada . "</td>
                    <td>" . $row['ent_costo'] . "</td>
                    <td>" . $row['ent_cantidad'] . "</td>
                    <td>" . $row['prod_nombre'] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No hay entradas registradas</td></tr>";
    }
    ?>
</table>

        </div>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
