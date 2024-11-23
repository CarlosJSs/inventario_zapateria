<?php
  session_start();
  if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
  }
  include '../config/database.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario</title>
  <link rel="stylesheet" href="./../public/css/inventario.css">
  <script defer src="./../public/js/inventarioTable.js"></script>
</head>
<body>
  <h1 class="pageTitle">Inventario principal.</h1>
  <div class="mainContainer">
    <div class="filterContainer">
      <input type="text" id="productFilter" placeholder="Filtrar por producto" class="filterInput">
      <input type="date" id="dateFilter" class="filterInput">
      <input type="number" id="quantityFilter" placeholder="Filtrar por cantidad" class="filterInput">
      <button id="clearFilters" class="btnFilter">Limpiar Filtros</button>
    </div>
    <div class="tableContainer">
      <table class="customTable" id="inventoryTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>
              Fecha de Actualización
              <button class="sortButton" data-sort="fecha-asc">↑</button>
              <button class="sortButton" data-sort="fecha-desc">↓</button>
            </th>
            <th>
              Cantidad
              <button class="sortButton" data-sort="cantidad-asc">↑</button>
              <button class="sortButton" data-sort="cantidad-desc">↓</button>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php
          $select = "SELECT producto.prod_id AS productoID,
                            producto.prod_nombre AS prodNombre,
                            stock.sto_fecha_update AS sto_fechaUp,
                            stock.sto_cantidad AS sto_cantidad
                        from stock 
                            inner join producto 
                                on stock.sto_prod_id = producto.prod_id";

          $result = $conexion->query($select);

          if ($result->num_rows > 0) {
            while ($stock = $result->fetch_assoc()) {
              echo "<tr>";
                echo "<td>" . $stock['productoID'] . "</td>";
                echo "<td>" . $stock['prodNombre'] . "</td>";
                echo "<td>" . $stock['sto_fechaUp'] . "</td>";
                echo "<td>" . $stock['sto_cantidad'] . "</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No hay datos disponibles</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>