<?php
include('./../config/database.php');

$sql = "
SELECT 
    DATE(ent_fecha) AS fecha, 
    SUM(ent_cantidad) AS total_entradas 
FROM entrada 
GROUP BY DATE(ent_fecha)
UNION ALL
SELECT 
    DATE(sal_fecha) AS fecha, 
    -SUM(sal_cantidad) AS total_salidas 
FROM salida 
GROUP BY DATE(sal_fecha)
ORDER BY fecha;
";

$result = $conexion->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
