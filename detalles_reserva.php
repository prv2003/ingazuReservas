<?php
// Función para obtener los detalles de la reserva desde la base de datos
function obtenerDetallesReserva($reservaId, $conn)
{
    // Consulta SQL para obtener los detalles de la reserva con el ID proporcionado
    $sql = "SELECT * FROM reserva WHERE reserva_id = $reservaId";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        // Obtener los detalles de la reserva como un array asociativo
        $row = $result->fetch_assoc();
        return $row;
    } else {
        // Si no se encontraron resultados, devolver un array vacío
        return array();
    }
}

// Verificar si se recibió un ID de reserva válido a través de la solicitud GET
if (isset($_GET['id'])) {
    // Obtener el ID de la reserva desde la solicitud GET
    $reservaId = $_GET['id'];

    // Configuración de la base de datos (reemplaza con tus propias credenciales)
    $user = "ingazues";
    $server = "localhost";
    $password = "ZKwuHSXxm5GqrFno5CSB";
    $database = "reservasIngazu";

    // Establecer conexión a la base de datos
    $conn = new mysqli($server, $user, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener los detalles de la reserva utilizando la función obtenerDetallesReserva
    $detallesReserva = obtenerDetallesReserva($reservaId, $conn);

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Imprimir los detalles de la reserva como HTML
    if (!empty($detallesReserva)) {
        echo "<p><strong>Nombre:</strong> " . $detallesReserva['nombre'] . "</p>";
        echo "<p><strong>Teléfono:</strong> " . $detallesReserva['telefono'] . "</p>";
        echo "<p><strong>Email:</strong> " . $detallesReserva['email'] . "</p>";
        echo "<p><strong>Mesa:</strong> " . $detallesReserva['mesa'] . "</p>";
        echo "<p><strong>Fecha:</strong> " . $detallesReserva['fecha'] . "</p>";
        echo "<p><strong>Hora:</strong> " . $detallesReserva['hora'] . "</p>";
        echo "<p><strong>Personas:</strong> " . $detallesReserva['personas'] . "</p>";
        echo "<p><strong>Mensaje:</strong> " . $detallesReserva['mensaje'] . "</p>";
    } else {
        echo "<p>No se encontraron detalles para la reserva seleccionada.</p>";
    }
} else {
    echo "<p>No se proporcionó un ID de reserva válido.</p>";
}
?>
