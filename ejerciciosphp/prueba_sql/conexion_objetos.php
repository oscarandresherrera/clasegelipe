<?php
$servername = "localhost";
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}
echo "Conexión correcta, con MySQL orientado a Objetos.</br>";

// Puedes añadir más código aquí para realizar consultas o interacciones con la base de datos

// Cerrar la conexión
$conn->close();
?>
