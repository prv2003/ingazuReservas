<?php
// Configuración de la base de datos
$user = "ingazues";
$server = "localhost";
$passWord = "ZKwuHSXxm5GqrFno5CSB";
$database = "reservasIngazu";
// Establecer conexión a la base de datos
$conn = new mysqli($server, $user, $passWord, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener la fecha de la solicitud AJAX
$fecha = $_GET['fecha'];

// Consultar las reservas para la fecha especificada
$sql = "SELECT * FROM reserva WHERE fecha = '$fecha'";
$result = $conn->query($sql);

$reservas = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
}

// Generar HTML para las reservas
$html = "<div class='row'>";
$html .= "<div class='col-md-6'>";
$html .= "<table border='1'>";
$html .= "<tr><th>Nombre</th><th>Mesa</th><th>Hora</th><th>Comensales</th></tr>";

// Iterar sobre cada reserva
foreach ($reservas as $reserva) {
    $html .= "<tr id='reserva-" . $reserva['reserva_id'] . "'>";
    $html .= "<td>" . $reserva['nombre'] . "</td>";
    $html .= "<td>" . $reserva['mesa'] . "</td>";
    $html .= "<td>" . $reserva['hora'] . "</td>";
    $html .= "<td>" . $reserva['personas'] . "</td>";
    $html .= "</tr>";
}

$html .= "</table>";
$html .= "</div>";
$html .= "</div>";

// Devolver el HTML generado
echo $html;

// Cerrar la conexión a la base de datos
$conn->close();
?>
