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

$fecha = $_GET['fecha'];

$sql = "SELECT * FROM reserva WHERE fecha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo "<table class='table table-bordered'>";
  echo "<thead><tr><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Personas</th><th>Hora</th></tr></thead>";
  echo "<tbody>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr reservaId='{$row['id']}'>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>{$row['telefono']}</td>";
    echo "<td>{$row['personas']}</td>";
    echo "<td>{$row['hora']}</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
} else {
  echo "<p>No hay reservas para esta fecha.</p>";
}

$stmt->close();
$conn->close();
?>
