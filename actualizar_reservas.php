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

$fecha = $_GET['fecha'];

// Dividir la fecha en partes (día, mes, año)
list($dia, $mes, $anio) = explode('/', $fecha);

// Construir la fecha en formato "Y-m-d"
$fecha_sql = sprintf("%04d-%02d-%02d", $anio, $mes, $dia);

// Consultar las reservas para la fecha especificada
$sql = "SELECT * FROM reserva where fecha = '$fecha_sql'";
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
$html .= "</div>";// Agregar la sección de detalles de las reservas
$html .= "<div class='col-md-6 d-flex justify-content-center align-items-center'>";
$html .= "<div class='text-center'>";
$html .= "<h2>Detalles de Reserva</h2>";
$html .= "<div class='reserva-card'>";
$html .= "<div class='info'>";
$html .= "<p><strong>Nombre:</strong> </p>";
$html .= "<p><strong>Teléfono:</strong> </p>";
$html .= "<p><strong>Email:</strong> </p>";
$html .= "<p><strong>Mesa:</strong> </p>";
$html .= "<p><strong>Fecha:</strong> </p>";
$html .= "<p><strong>Hora:</strong> </p>";
$html .= "<p><strong>Personas:</strong> </p>";
$html .= "</div>";
$html .= "</div>";
$html .= "</div>";
$html .= "</div>";

$html .= "</div>"; // Cierre de la fila

// Devolver el HTML generado
echo $html;

// Cerrar la conexión a la base de datos
$conn->close();
?>
<script>
    // Manejar clic en las filas de la tabla de reservas
    $(document).ready(function () {
        $('table').on('click', 'tr', function () {
            // Obtener el ID de la reserva de la fila clickeada
            var reservaId = $(this).attr('id').split('-')[1]; // Eliminar 'reserva-' del ID

            // Obtener los detalles de la reserva con AJAX (si es necesario) y actualizar la sección de "Reserva Card"
            $.ajax({
                url: 'detalles_reserva.php', // URL para obtener los detalles de la reserva
                method: 'GET',
                data: { id: reservaId }, // Enviar el ID de la reserva
                success: function (response) {
                    // Actualizar la sección de "Reserva Card" con los detalles de la reserva
                    $('.reserva-card .info').html(response);
                    // Mostrar la sección de "Reserva Card"
                    $('.reserva-card').show();
                },
                error: function () {
                    alert('Error al cargar los detalles de la reserva.');
                }
            });
        });
    });
</script>
