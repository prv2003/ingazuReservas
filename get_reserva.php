<?php
// Configuración de la base de datos
$user = "admin";
$server = "localhost";
$passWord = "Ingazu2024.";
$database = "reservasIngazu";

// Establecer conexión a la base de datos
$conn = new mysqli($server, $user, $passWord, $database);

// Verificar conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

$id = $_GET['id'];

if (!empty($id)) {
  $sql = "SELECT * FROM reserva WHERE reserva_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<div class='reserva-card'>";
    echo "<div class='info'>";
    echo "<p><strong>Mesa:</strong> " . $row['mesa'] . "</p>";
    echo "<p><strong>Hora:</strong> " . $row['hora'] . "</p>";
    echo "<p><strong>Personas:</strong> " . $row['personas'] . "</p>";
    echo "<p><strong>Nombre:</strong> " . $row['nombre'] . "</p>";
    echo "<p><strong>Teléfono:</strong> " . $row['telefono'] . "</p>";
    echo "</div>";
    echo "</div>";
  } else {
    echo "<p>No se encontró la reserva.</p>";
  }

  $stmt->close();
} else {
  echo "<p>ID de reserva no válido.</p>" . "id:" .$id;
}

$conn->close();
?>
