<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/database.php';  // Asegúrate de que la ruta del archivo de configuración sea correcta

// Agregar un nuevo proveedor
if (isset($_POST['add_proveedor'])) {
    $nombre = $_POST['prov_nombre'];
    $telefono = $_POST['prov_telefono'];
    $correo = $_POST['prov_correo'];

    // Consulta para insertar proveedor
    $insertQuery = "INSERT INTO proveedor (prov_nombre, prov_telefono, prov_correo) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($insertQuery);
    $stmt->bind_param("sss", $nombre, $telefono, $correo);
    $stmt->execute();
    $stmt->close();
}

// Eliminar un proveedor
if (isset($_POST['delete_proveedor'])) {
    $prov_id = $_POST['prov_id'];

    // Consulta para eliminar proveedor
    $deleteQuery = "DELETE FROM proveedor WHERE prov_id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param("i", $prov_id);
    $stmt->execute();
    $stmt->close();
}

// Obtener los proveedores
$query = "SELECT * FROM proveedor";
$result = $conexion->query($query);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Proveedores</h1>

        <div class="row">
            <!-- Formulario para agregar un nuevo proveedor -->
            <div class="col-md-5">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Agrega Nuevo Proveedor</h5>
                    </div>
                    <div class="card-body">
                        <form action="proveedores.php" method="post">
                            <div class="mb-3">
                                <label for="prov_nombre" class="form-label">Nombre:</label>
                                <input type="text" name="prov_nombre" id="prov_nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="prov_telefono" class="form-label">Teléfono:</label>
                                <input type="text" name="prov_telefono" id="prov_telefono" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="prov_correo" class="form-label">Correo Electrónico:</label>
                                <input type="email" name="prov_correo" id="prov_correo" class="form-control" required>
                            </div>
                            <button type="submit" name="add_proveedor" class="btn btn-primary w-100">Agregar Proveedor</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mostrar  proveedores existentes -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Proveedores Existentes</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row["prov_id"]) ?></td>
                                            <td><?= htmlspecialchars($row["prov_nombre"]) ?></td>
                                            <td><?= htmlspecialchars($row["prov_telefono"]) ?></td>
                                            <td><?= htmlspecialchars($row["prov_correo"]) ?></td>
                                            <td>
                                                <form action="proveedores.php" method="post" class="d-inline">
                                                    <input type="hidden" name="prov_id" value="<?= htmlspecialchars($row["prov_id"]) ?>">
                                                    <button type="submit" name="delete_proveedor" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No hay proveedores registrados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
