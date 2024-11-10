<?php
  define('BASE_PATH', __DIR__);

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    //Llevar registro de la session
    session_start();

    // isset -> si la variable esta generada y esta siendo utilizada
    if(isset($_SESSION['admin'])){
      header('Location: views/panel.php');
    }else{
      header('Location: views/login.php');
    }

  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
      http_response_code(200);
      exit();
  }

  require_once BASE_PATH . '/simpleRouter.php';
  require_once BASE_PATH . '/controllers/adminController.php';
  require_once BASE_PATH . '/middleware/authMiddleware.php';

  $router = new SimpleRouter();
  $adminController = new AdminController();
  
  $router->post('/productos', function() use ($productoController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->crearProducto($data));
  });

  $router->put('/productos', function() use ($productoController) {
    $data = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->actualizarProducto($data));
  });

  $router->delete('/productos', function() use ($productoController) {
    $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->borrarProducto($id));
  });

  $router->post('/productos/detalle', function() use ($productoController) {
    $id = json_decode(file_get_contents("php://input"), true);
    return json_encode($productoController->obtenerProductoPorId($id));
  });

  $router->get('/productos', function() use ($productoController) {
    return json_encode($productoController->obtenerProductos());
  });

  $router->dispatch();
?>