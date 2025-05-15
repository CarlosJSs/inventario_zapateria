<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $producto = $_POST['producto'] ?? null;
    $fecha = $_POST['fecha'] ?? null;
    $cantidad = (int)($_POST['cantidad'] ?? 0);

    if (empty($producto) || empty($fecha) || $cantidad <= 0) {
        $_SESSION['mensaje'] = "Por favor, complete todos los campos correctamente.";
        header("Location: layout.php?page=salidas");
        exit();
    } else {
        // Consulta para verificar stock y precio
        $querySelect = "SELECT sto_cantidad, p.prod_precio FROM stock s 
                        INNER JOIN producto p ON s.sto_prod_id = p.prod_id 
                        WHERE s.sto_prod_id = ? AND sto_cantidad >= ?";
        $stmtSelect = $conexion->prepare($querySelect);
        $stmtSelect->bind_param("ii", $producto, $cantidad);
        $stmtSelect->execute();
        $stmtSelect->bind_result($sto_cantidad, $precio_venta);

        if ($stmtSelect->fetch()) {
            $stmtSelect->close();

            date_default_timezone_set('America/Mexico_City');
            $fecha_con_hora = $fecha . ' ' . date('H:i:s');
            $ganancia = $precio_venta * $cantidad;

            $conexion->begin_transaction();

            try {

                // Insertar salida
                $insert = "INSERT INTO salida (sal_cantidad, sal_fecha, sal_prod_id, sal_ganancia) VALUES (?, ?, ?, ?)";
                $stmtInsert = $conexion->prepare($insert);
                $stmtInsert->bind_param("issd", $cantidad, $fecha_con_hora, $producto, $ganancia);
                if (!$stmtInsert->execute()) {
                    throw new Exception("Error al registrar la salida.");
                }
                $stmtInsert->close();

                $conexion->commit();
                $_SESSION['mensaje'] = "Salida registrada y stock actualizado correctamente.";
                header("Location: layout.php?page=panel");
                exit();

            } catch (Exception $e) {
                $conexion->rollback();
                $_SESSION['mensaje'] = "Error: " . $e->getMessage();
                header("Location: layout.php?page=panel");
                exit();
            }
        } else {
            $stmtSelect->close();
            $_SESSION['mensaje'] = "No hay suficiente stock para la cantidad solicitada.";
            header("Location: layout.php?page=panel");
        }
    }
}
?>