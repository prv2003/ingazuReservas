<?php
$user = "admin";
$server = "localhost";
$passWord = "Ingazu2024.";
$database = "reservasIngazu";

$conn = new mysqli($server, $user, $passWord, $database);

// Verificar conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = !empty($_POST["telefono"]) ? $_POST["telefono"] : null;
    $numpersonas = $_POST["numpersonas"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $mesa = $_POST["mesa"];
    $mensaje = $_POST["mensaje"];
  
    
  
    //$fecha_formateada = date("YYYY-mm-dd", strtotime($_POST["fecha"]));
    //$hora_formateada = date("HH:ii:ss", strtotime($_POST["hora"]));
  
  
    // Preparar la consulta SQL para insertar la reserva
    $sql_insert = "INSERT INTO reserva (nombre, email, telefono, personas, fecha, hora, mesa, mensaje) 
    VALUES ('$nombre', '$email', '$telefono', '$numpersonas', '$fecha', '$hora', '$mesa', '$mensaje')";
  
    // Ejecutar la consulta
    if ($conn->query($sql_insert) === TRUE) {
      echo '<script>alert("Reserva creada con éxito.");</script>';
      // Redireccionar al usuario a la página de reservas nuevamente
      
    } else {
      echo "<script>alert('Error de reserva.');</script> Error al crear la reserva: " . $conn->error;
    }
  }
  $conn->close();
?>