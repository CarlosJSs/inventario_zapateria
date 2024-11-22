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
            <h3>Entradas y Salidas por Día</h3>
            <canvas id="chartEntradasSalidas"></canvas>
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
<script>
fetch('./../queries/in_out_dayWeek.php')
    .then(response => response.json())
    .then(data => {
        const fechas = data.map(item => item.fecha);
        const valores = data.map(item => item.total_entradas);

        const ctx = document.getElementById('chartEntradasSalidas').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: fechas,
                datasets: [{
                    label: 'Entradas y Salidas',
                    data: valores,
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });
    });
</script>

<script>
fetch('./../queries/mas_vendidos.php')
    .then(response => response.json())
    .then(data => {
        const productos = data.map(item => item.producto);
        const cantidades = data.map(item => item.total_vendidos);

        const ctx = document.getElementById('chartProductosMasVendidos').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productos,
                datasets: [{
                    label: 'Productos más vendidos',
                    data: cantidades,
                    backgroundColor: 'green'
                }]
            }
        });
    });
</script>

<script>
fetch('./../queries/categoria_dist.php')
    .then(response => response.json())
    .then(data => {
        const categorias = data.map(item => item.categoria);
        const cantidades = data.map(item => item.total_productos);

        const ctx = document.getElementById('chartDistribucionCategorias').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categorias,
                datasets: [{
                    label: 'Distribución por Categoría',
                    data: cantidades,
                    backgroundColor: ['red', 'blue', 'green', 'yellow']
                }]
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
fetch('./../queries/categoria_vend.php') // Ruta al archivo PHP
    .then(response => response.json())
    .then(data => {
        const categorias = data.map(item => item.categoria);
        const cantidades = data.map(item => item.total_vendidos);

        const ctx = document.getElementById('chartCategoriasMasVendidas').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categorias,
                datasets: [{
                    label: 'Categorías Más Vendidas',
                    data: cantidades,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)', 
                        'rgba(54, 162, 235, 0.7)', 
                        'rgba(255, 206, 86, 0.7)', 
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    });
</script>

</body>
</html>