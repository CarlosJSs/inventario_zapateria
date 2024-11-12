<?php
  session_start();
  if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario Zapatería</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
      <h1 class="text-center mb-4">Inventario de Zapatería</h1>
      <div id="alertContainer" class="my-3"></div>

      <div class="row">
          <div class="col-md-5">
              <div class="card mb-4">
                  <div class="card-header bg-primary text-white">
                      <h5 class="mb-0">Agregar Entrada de Producto</h5>
                  </div>
                  <div class="card-body">
                      <form id="entryForm">
                          <input type="hidden" id="entryId">
                          
                          <div class="mb-3">
                              <label for="nombre" class="form-label">Nombre del Producto</label>
                              <input type="text" class="form-control" id="nombre" required>
                          </div>

                          <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedor</label>
                            <select class="form-control" id="proveedor" required>
                                <option value="" disabled selected>Seleccione un proveedor</option>
                                <option value="Proveedor A">Nike</option>
                                <option value="Proveedor B">Adidas</option>
                                <option value="Proveedor C">Puma</option>
                            </select>
                        </div>

                          <div class="mb-3">
                              <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
                              <input type="datetime-local" class="form-control" id="fecha_entrada" required>
                          </div>

                          <div class="mb-3">
                              <label for="costo" class="form-label">Costo Unitario</label>
                              <input type="number" class="form-control" id="costo" min="0" step="0.01" required>
                          </div>

                          <div class="mb-3">
                              <label for="cantidad" class="form-label">Cantidad</label>
                              <input type="number" class="form-control" id="cantidad" min="1" required>
                          </div>

                          <button type="submit" id="submitBtn" class="btn btn-primary w-100">
                              Agregar Entrada
                          </button>
                      </form>
                  </div>
              </div>
          </div>

          <div class="col-md-7">
              <div class="card">
                  <div class="card-header bg-secondary text-white">
                      <h5 class="mb-0">Lista de Entradas de Productos</h5>
                  </div>
                  <div class="card-body">
                      <ul id="entryList" class="list-group">
                          <li class="list-group-item text-center text-muted">Aún no hay entradas agregadas.</li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>

</body>
</html>
