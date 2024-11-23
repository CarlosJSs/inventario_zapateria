<?php
include('./../config/database.php');

$sql = "
SELECT 
    p.prod_nombre AS producto, 
    SUM(s.sal_cantidad) AS total_vendidos 
FROM salida s
JOIN producto p ON s.sal_prod_id = p.prod_id
GROUP BY s.sal_prod_id
ORDER BY total_vendidos DESC
LIMIT 5;
";

$result = $conexion->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>