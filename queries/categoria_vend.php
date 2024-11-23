<?php
include('./../config/database.php');

$sql = "
SELECT 
    c.cat_nombre AS categoria, 
    SUM(s.sal_cantidad) AS total_vendidos 
FROM salida s
JOIN producto p ON s.sal_prod_id = p.prod_id
JOIN categoria c ON p.prod_cat_id = c.cat_id
GROUP BY c.cat_id
ORDER BY total_vendidos DESC;
";

$result = $conexion->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Devolver los datos como JSON
echo json_encode($data);
?>
