<?php
  //Llevar registro de la session
  session_start();

  // isset -> si la variable esta generada y esta siendo utilizada
  if(isset($_SESSION['admin'])){
    header('Location: views/layout.php');
  }else{
    header('Location: views/login.php');
  }
?>
