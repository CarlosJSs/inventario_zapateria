<?php
include('./../config/database.php');

// Consulta para los últimos movimientos
$query = "
    SELECT 'Entrada' AS tipo, e.ent_fecha AS fecha, p.prod_nombre AS producto, e.ent_cantidad AS cantidad
    FROM entrada e
    JOIN producto p ON e.ent_prod_id = p.prod_id
    UNION
    SELECT 'Salida' AS tipo, s.sal_fecha AS fecha, p.prod_nombre AS producto, s.sal_cantidad AS cantidad
    FROM salida s
    JOIN producto p ON s.sal_prod_id = p.prod_id
    ORDER BY fecha DESC
    LIMIT 6
";

$result = $conexion->query($query);

// Generar filas de la tabla
$movimientos = [];
while ($row = $result->fetch_assoc()) {
    $movimientos[] = $row;
}

// Enviar datos en formato JSON a JavaScript
echo json_encode($movimientos);
?>
