<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  // Crear conexión con PDO
  $conn = new PDO("mysql:host=$servername;dbname=", $username, $password);
  // Establecer el modo de error de PDO a excepciones
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Conexión exitosa, con PDO orientado a objetos.</br>";
} catch(PDOException $e) {
  echo "Conexión fallida, con PDO: " . $e->getMessage() . "</br>";
}

// Puedes añadir más código aquí para realizar consultas o interacciones con la base de datos

// Cerrar la conexión
$conn = null;
?>

