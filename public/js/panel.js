fetch('./../queries/in_out_dayWeek.php')
  .then(response => response.json())
    .then(data => {
      const fechas = data.map(item => item.fecha)
      const valores = data.map(item => item.total_entradas)

      const ctx = document.getElementById('chartEntradasSalidas').getContext('2d')
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
      })
    })


fetch('./../queries/mas_vendidos.php')
  .then(response => response.json())
    .then(data => {
      const productos = data.map(item => item.producto)
      const cantidades = data.map(item => item.total_vendidos)

      const ctx = document.getElementById('chartProductosMasVendidos').getContext('2d')
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
      })
    })


fetch('./../queries/categoria_dist.php')
  .then(response => response.json())
    .then(data => {
      const categorias = data.map(item => item.categoria)
      const cantidades = data.map(item => item.total_productos)

      const ctx = document.getElementById('chartDistribucionCategorias').getContext('2d')
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
      })
    })


fetch('./../queries/categoria_vend.php')
  .then(response => response.json())
    .then(data => {
      const categorias = data.map(item => item.categoria)
      const cantidades = data.map(item => item.total_vendidos)

      const ctx = document.getElementById('chartCategoriasMasVendidas').getContext('2d')
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
      })
    })


document.addEventListener("DOMContentLoaded", function () {
  fetch("./../queries/get_lastMov.php") // Cambia por la ruta a tu archivo PHP
    .then((response) => response.json())
    .then((data) => {
      const tableBody = document.getElementById("movimientosTableBody")
      data.forEach((movimiento) => {
        const row = `
          <tr>
            <td>${new Date(movimiento.fecha).toLocaleString()}</td>
            <td>${movimiento.tipo}</td>
            <td>${movimiento.producto}</td>
            <td>${movimiento.cantidad}</td>
          </tr>
        `
        tableBody.innerHTML += row
      })
    })
    .catch((error) => console.error("Error al cargar movimientos:", error))
})