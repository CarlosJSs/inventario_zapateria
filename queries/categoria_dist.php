<?php
include('./../config/database.php');

$sql = "
SELECT 
    c.cat_nombre AS categoria, 
    COUNT(p.prod_id) AS total_productos 
FROM producto p
JOIN categoria c ON p.prod_cat_id = c.cat_id
GROUP BY c.cat_id;
";

$result = $conexion->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>