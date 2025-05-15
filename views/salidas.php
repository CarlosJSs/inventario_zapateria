<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';

// Obtener productos con stock > 0
$query_productos = "SELECT p.prod_id, p.prod_nombre, s.sto_cantidad 
                    FROM producto p 
                    INNER JOIN stock s ON p.prod_id = s.sto_prod_id
                    WHERE s.sto_cantidad > 0";
$result_productos = $conexion->query($query_productos) or die("Error al obtener productos: " . $conexion->error);

// Obtener salidas
$query_salidas = "SELECT s.sal_id, p.prod_nombre, s.sal_cantidad, s.sal_fecha, s.sal_ganancia 
                    FROM salida s
                    INNER JOIN producto p ON s.sal_prod_id = p.prod_id
                    ORDER BY s.sal_fecha DESC";
$result_salidas = $conexion->query($query_salidas) or die("Error al obtener salidas: " . $conexion->error);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gestión de Salidas</title>
    <link rel="stylesheet" href="./../public/css/salidas.css" />
</head>
<body>
    <h2 class="title">Gestión de Salidas</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="container-flex">        
        <div class="modal">
            <form method="POST" class="form" action="procesar_salida.php" autocomplete="off">
                <div class="titleCard">Salida</div>
                <div class="descCard">
                    <div class="descInfo">Seleccione un producto y registre la salida</div>
                </div>
                <div class="formSal">
                    <div class="input_container">
                        <label for="namePro" class="input_label">Producto</label>
                        <select id="namePro" class="input_field" name="producto" required>
                            <option value="" disabled selected>Seleccione un producto</option>
                            <?php while ($row = $result_productos->fetch_assoc()): ?>
                                <option value="<?= $row['prod_id'] ?>">
                                    <?= htmlspecialchars($row['prod_nombre']) ?> (Stock: <?= $row['sto_cantidad'] ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="input_container">
                        <label for="date" class="input_label">Fecha</label>
                        <input id="date" class="input_field" type="date" name="fecha" required>
                    </div>
                    <div class="input_container">
                        <label for="cantidad" class="input_label">Cantidad</label>
                        <input id="cantidad" class="input_field" type="number" name="cantidad" min="1" required>
                    </div>
                </div>
                <button type="submit" class="purchase--btn">Registrar Salida</button>
            </form>
        </div>

        <div class="modal-table">
            <h3>Historial de Salidas</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Ganancia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_salidas->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['sal_id'] ?></td>
                            <td><?= htmlspecialchars($row['prod_nombre']) ?></td>
                            <td><?= $row['sal_cantidad'] ?></td>
                            <td><?= $row['sal_fecha'] ?></td>
                            <td>$<?= number_format($row['sal_ganancia'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
