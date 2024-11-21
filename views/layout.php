<?php
  session_start();
  if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
  }
  include '../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="">
  <title>Panel de Administrador</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/ae67df2373.js" crossorigin="anonymous"></script>
    <!-- Estilos -->
    <link rel="stylesheet" href="../public/css/layout.css">
</head>
<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>

  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="">
        <img src="https://cdn-icons-png.flaticon.com/512/860/860895.png" width="26px" height="26px" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Archive Shoes :)</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('panel')" id="panel" data-page="panel">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-home text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Panel</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('productos')" id="productos" data-page="productos">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-cube text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Productos</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('entradas')" id="entradas" data-page="entradas">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-arrow-circle-down text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Entradas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('salidas')" id="salidas" data-page="salidas">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-arrow-circle-up text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Salidas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('proveedores')" id="proveedores" data-page="proveedores">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-handshake-o text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Proveedores</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('categorias')" id="categorias" data-page="categorias">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-folder text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Categorias</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('inventario')" id="inventario" data-page="inventario">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-archive text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Inventario</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Otros</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="navigate('admin')" id="admin" data-page="admin">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Administradores</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" onclick="logout()">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-sign-out text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Cerrar sesion</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Bienvenido:</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0"><?php echo $_SESSION['user_name'] ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <ul class="navbar-nav  justify-content-end">
            
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            
          </ul>

        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <!-- Aqui van los views/pages-->
    <?php
      // Cargar el contenido dinámico
      if (isset($_GET['page'])) {
          $page = $_GET['page'];
          $file = "{$page}.php";
          if (file_exists($file)) {
              include $file;
          } else {
              include "default.php";
          }
      } else {
          include "default.php";
      }
    ?>

  </main>
  <script src="../public/js/layout.js"></script>
</body>
</html>