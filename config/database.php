<?php
  /*
  class Database {
    private $host = 'localhost:8889';
    private $db_name = 'inventario_zapateria';
    private $username = 'root';
    private $password = 'root';
    private $conn;

    public function getConnection() {
      $this->conn = null;

      try {
        $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Error de conexion: " . $e->getMessage();
      }
      return $this->conn;
    }
  }
  */
?>

<?php
  $servidor = 'localhost:8889';
  $usuario = 'root';
  $password = 'root';
  $bd = 'inventario_zapateria';

  // Conectar a la Base de Datos
  $conexion = new mysqli($servidor, $usuario, $password, $bd);
  if($conexion->connect_error){
    die('Conexion fallida '.$conexion->connect_error);
  }
?>