<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_nombre = $_POST['prod_nombre'];
    $prod_desc = $_POST['prod_desc'];
    $prod_marca = $_POST['prod_marca'];
    $prod_precio = $_POST['prod_precio'];
    $prod_talla = $_POST['prod_talla'];
    $prod_tipo = $_POST['prod_tipo'];
    $prod_cat_id = $_POST['prod_cat_id'];
    $prod_color = $_POST['prod_color'];

    $stmt = $conexion->prepare("INSERT INTO producto (prod_nombre, prod_desc, prod_marca, prod_precio, prod_talla, prod_tipo, prod_cat_id, prod_color) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdssss", $prod_nombre, $prod_desc, $prod_marca, $prod_precio, $prod_talla, $prod_tipo, $prod_cat_id, $prod_color);

    if ($stmt->execute()) {
        $mensaje = "Producto agregado correctamente.";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener datos de la tabla 
$sql_productos = "SELECT p.prod_id, p.prod_nombre, p.prod_desc, p.prod_marca, p.prod_precio, 
                         p.prod_talla, p.prod_tipo, c.cat_nombre AS categoria, p.prod_color 
                  FROM producto p
                  JOIN categoria c ON p.prod_cat_id = c.cat_id";
$result_productos = $conexion->query($sql_productos);

// Obtener categorías
$sql_categorias = "SELECT cat_id, cat_nombre FROM categoria";
$result_categorias = $conexion->query($sql_categorias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../public/css/productos.css">
</head>
<body>
<h2 class="title">Gestión de Productos</h2>
    <div class="container-flex">
        <div class="modal">
            <h1 class="myTitle">Agregar nuevo producto</h1>
            <form method="POST" action="" class="form">
                <div class="form">
                    <!-- Columna 1 -->
                    <div class="form-column">
                        <div class="input_container">
                            <label for="prod_nombre" class="input_label">Nombre del Producto:</label>
                            <input type="text" name="prod_nombre" id="prod_nombre" class="input_field" required>
                        </div>

                        <div class="input_container">
                            <label for="prod_desc" class="input_label">Descripción:</label>
                            <textarea name="prod_desc" id="prod_desc" class="input_field" rows="3" required></textarea>
                        </div>

                        <div class="input_container">
                            <label for="prod_marca" class="input_label">Marca:</label>
                            <input type="text" name="prod_marca" id="prod_marca" class="input_field" required>
                        </div>

                        <div class="input_container">
                            <label for="prod_precio" class="input_label">Precio:</label>
                            <input type="number" name="prod_precio" id="prod_precio" class="input_field" min="0" step="0.01" required>
                        </div>
                    </div>

                    <!-- Columna 2 -->
                    <div class="form-column">
                        <div class="input_container">
                            <label for="prod_talla" class="input_label">Talla:</label>
                            <input type="text" name="prod_talla" id="prod_talla" class="input_field" required>
                        </div>

                        <div class="input_container">
                            <label for="prod_tipo" class="input_label">Tipo:</label>
                            <select name="prod_tipo" id="prod_tipo" class="input_field" required>
                                <option value="Caballero">Caballero</option>
                                <option value="Dama">Dama</option>
                                <option value="Nino">Nino</option>
                            </select>
                        </div>

                        <div class="input_container">
                            <label for="prod_cat_id" class="input_label">Categoría:</label>
                            <select name="prod_cat_id" id="prod_cat_id" class="input_field" required>
                                <?php
                                if ($result_categorias->num_rows > 0) {
                                    while ($row = $result_categorias->fetch_assoc()) {
                                        echo "<option value='" . $row['cat_id'] . "'>" . $row['cat_nombre'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No hay categorías disponibles</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="input_container">
                            <label for="prod_color" class="input_label">Color:</label>
                            <input type="text" name="prod_color" id="prod_color" class="input_field" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="purchase--btn">Guardar Producto</button>
            </form>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="container-flex">
        <div class="modal-table">
            <h2 class="titleTable">Productos Registrados</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Talla</th>
                    <th>Tipo</th>
                    <th>Categoría</th>
                    <th>Color</th>
                </tr>
                <?php
                if ($result_productos->num_rows > 0) {
                    while ($row = $result_productos->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['prod_id'] . "</td>
                                <td>" . htmlspecialchars($row['prod_nombre']) . "</td>
                                <td>" . htmlspecialchars($row['prod_desc']) . "</td>
                                <td>" . htmlspecialchars($row['prod_marca']) . "</td>
                                <td>$" . number_format($row['prod_precio'], 2) . "</td>
                                <td>" . htmlspecialchars($row['prod_talla']) . "</td>
                                <td>" . htmlspecialchars($row['prod_tipo']) . "</td>
                                <td>" . htmlspecialchars($row['categoria']) . "</td>
                                <td>" . htmlspecialchars($row['prod_color']) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay productos registrados</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>