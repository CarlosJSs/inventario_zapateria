<?php
	session_start();
	if(!isset($_SESSION['usuario'])){
		header("Location: login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de inicio</title>
  <link rel="stylesheet" href="./../public/css/panel.css">
</head>
<body>
  <h2 class="pageTitle">Bienvenido al panel de inicio de su sistema.</h2>
		<div class="mainContainer">
			<div class="chart-container">
				<div class="chart-box">
						<h3>Últimos Movimientos</h3>
						<table class="styled-table">
								<thead>
										<tr>
												<th>Fecha</th>
												<th>Tipo</th>
												<th>Producto</th>
												<th>Cantidad</th>
										</tr>
								</thead>
								<tbody id="movimientosTableBody">
										<!-- Filas de movimientos generadas dinámicamente -->
								</tbody>
						</table>
				</div>
				<div class="chart-box">
						<h3>Productos Más Vendidos</h3>
						<canvas id="chartProductosMasVendidos"></canvas>
				</div>
				<div class="chart-box">
						<h3>Distribución por Categoría</h3>
						<canvas id="chartDistribucionCategorias"></canvas>
				</div>
				<div class="chart-box">
						<h3>Categorías Más Vendidas</h3>
						<canvas id="chartCategoriasMasVendidas"></canvas>
				</div>
		</div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="./../public/js/panel.js"></script>
</body>
</html>