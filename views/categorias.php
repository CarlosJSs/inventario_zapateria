<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include '../config/database.php';

// Agregar Categoría
if (isset($_POST['add_categoria'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Consulta para insertar categoría
    $insertQuery = "INSERT INTO categoria (cat_nombre, cat_desc) VALUES (?, ?)";
    $stmt = $conexion->prepare($insertQuery);
    $stmt->bind_param("ss", $nombre, $descripcion);
    $stmt->execute();
    $stmt->close();
    header('Location: ../views/layout.php?page=categorias');
}

// Eliminar Categoría
if (isset($_POST['delete_categoria'])) {
    $cat_id = $_POST['cat_id'];

    // Consulta para eliminar categoría
    $deleteQuery = "DELETE FROM categoria WHERE cat_id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();
    $stmt->close();
    header('Location: ../views/layout.php?page=categorias');
}

// Obtener las categorías existentes
$selectQuery = "SELECT * FROM categoria";
$result = $conexion->query($selectQuery);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../public/css/categorias.css">
</head>
<body>
    <h1 class="pageTitle">Gestión de Categorías</h1>
    <div class="container mt-5">
        <h1 class="text-center mb-4"></h1>

        <div class="row">
            <!-- Formulario para agregar nueva categoría -->
            <div class="col-md-5">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Agrega Nueva Categoría</h5>
                    </div>
                    <div class="card-body">
                        <form action="categorias.php" method="post">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción:</label>
                                <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                            </div>
                            <button type="submit" name="add_categoria" class="btn btn-primary w-100">Agregar Categoría</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mostrar las categorías existentes -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Categorías Existentes</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row["cat_id"]) ?></td>
                                            <td><?= htmlspecialchars($row["cat_nombre"]) ?></td>
                                            <td><?= htmlspecialchars($row["cat_desc"]) ?></td>
                                            <td>
                                                <form action="categorias.php" method="post" class="d-inline">
                                                    <input type="hidden" name="cat_id" value="<?= htmlspecialchars($row["cat_id"]) ?>">
                                                    <button type="submit" name="delete_categoria" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No hay categorías</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
