<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

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

// Consultar todas las reservas
$sql = "SELECT * FROM reserva";
$result = $conn->query($sql);

$reservas = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $reservas[] = $row;
  }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
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
    //echo '<script>alert("Reserva creada con éxito.");</script>';
    // Redireccionar al usuario a la página de reservas nuevamente
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
  } else {
    //echo "<script>alert('Error de reserva.');</script> Error al crear la reserva: " . $conn->error;
  }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ingazu - Reservas</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>

  <style>
    body {
      background-color: #fbfbfb;
    }

    @media (min-width: 991.98px) {
      main {
        padding-left: 240px;
      }
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding: 58px 0 0;
      /* Height of navbar */
      box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
      width: 240px;
      z-index: 600;
      transition: width 0.3s ease;
      /* Agregamos una transición para un cambio suave */
    }

    @media (max-width: 991.98px) {
      .sidebar {
        width: 20;
      }
    }

    #dropdownMenuButton {
      color: yellow;
      background-color: blue;
    }

    .form-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .form-control {
      border-radius: 20px;
    }

    /* Estilos para la tabla */
    table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #ddd;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #ddd;
    }

    .btn-primary {
      border-radius: 20px;
      width: 100%;
    }

    .sidebar .active {
      border-radius: 5px;
      box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
    }

    .sidebar-sticky {
      position: relative;
      top: 0;
      height: calc(100vh - 48px);
      padding-top: 0.5rem;
      overflow-x: hidden;
      overflow-y: auto;
    }

    #submit {
      color: yellow;
      margin-top: 15px;
    }

    #toggle-sidebar-btn {
      position: absolute;
      top: 10px;
      left: 10px;
      z-index: 1000;
      /* Asegura que el botón esté sobre el sidebar */
    }

    section {
      display: none;
    }

    .reserva-card {
      background-color: #ffffff;
      border: 1px solid #cccccc;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .reserva-card .info {
      font-family: Arial, sans-serif;
      color: #333333;
    }

    .reserva-card .info p {
      margin: 0;
      padding: 5px 0;
      font-size: 16px;
    }

    .reserva-card .info p strong {
      font-weight: bold;
    }

    section.active {
      display: block;
    }
  </style>
</head>

<body>
  <!--Main Navigation-->
  <header>

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a href="#nueva-reserva-section" class="list-group-item list-group-item-action py-2 ripple">
            <i class="icon ion-md-add-circle lead mr-2"></i><span> Nueva Reserva</span></a>
          <a href="#reservas-section" class="list-group-item list-group-item-action py-2 ripple active"
            aria-current="true">
            <i class="icon ion-md-list-box lead mr-2"></i><span> Reservas</span>
          </a>
          <a href="#calendario-section" class="list-group-item list-group-item-action py-2 ripple">
            <i class="icon ion-md-calendar lead mr-2"></i><span> Calendario</span></a>
          <a href="#clientes-section" class="list-group-item list-group-item-action py-2 ripple">
            <i class="icon ion-md-person lead mr-2"></i><span> Clientes</span></a>
        </div>
      </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="#">
          <img src="peque-logo_1.webp.png" height="25" alt="Ingazu Logo" loading="lazy" />
        </a>
        <!-- TITLE WEB -->
        <p class="d-none d-md-flex input-group w-auto my-auto">Gestión de Reservas - Ingazu </p>

        <!-- Right links -->
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" class="botonAmarilloAzul" type="button"
            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <strong>OPCIONES</strong>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Perfil</a>
            <a class="dropdown-item" href="#">Configuración</a>
            <a class="dropdown-item" href="#">Cerrar sesión</a>
          </div>
        </div>
      </div>
      <!-- Container wrapper -->
    </nav>

    <!-- Navbar -->
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main style="margin-top: 58px;">
    <div class="container pt-4">
      <!-- Secciones -->
      <section id="reservas-section">
        <!-- HTML para mostrar la lista de reservas -->
        <!-- Dentro de la sección de reservas -->
        <div class="text-center mb-3">
          <!-- Botón para retroceder día -->
          <button id="prevDay" class="btn btn-primary"><i class="icon ion-md-arrow-back"></i></button>
          <!-- Div para mostrar la fecha actual -->
          <div id="currentDateContainer" class="d-inline-block">
            <span id="currentDate"></span>
          </div>
          <!-- Botón para avanzar día -->
          <button id="nextDay" class="btn btn-primary"><i class="icon ion-md-arrow-forward"></i></button>
        </div>
    </div>

    <script>

      // Inicializar Flatpickr en el div que contiene la fecha actual
      flatpickr("#currentDateContainer", {
        inline: true, // Mostrar el calendario en línea
        dateFormat: "d-m-Y", // Formato de fecha dd-mm-yyyy
        onChange: function (selectedDates, dateStr, instance) {
          // Cuando se selecciona una fecha en el calendario, actualizar la fecha actual mostrada
          $('#currentDate').text(dateStr);
          // Aquí puedes agregar la lógica para cargar las reservas correspondientes a la fecha seleccionada
        }
      });
      // Obtener la fecha actual en formato YYYY-mm-dd
      var currentDate = new Date().toISOString().slice(0, 10);

      // Mostrar la fecha actual en el elemento correspondiente
      $('#currentDate').text(currentDate);

      // Cargar las reservas para la fecha actual
      //cargarReservas(currentDate);

      // Manejar clic en el botón de día anterior
      $('#prevDay').click(function () {
        var prevDate = new Date(currentDate);
        prevDate.setDate(prevDate.getDate() - 1);
        currentDate = prevDate.toISOString().slice(0, 10);
        $('#currentDate').text(currentDate);
        //cargarReservas(currentDate);
      });

      // Manejar clic en el botón de día siguiente
      $('#nextDay').click(function () {
        var nextDate = new Date(currentDate);
        nextDate.setDate(nextDate.getDate() + 1);
        currentDate = nextDate.toISOString().slice(0, 10);
        $('#currentDate').text(currentDate);
        //cargarReservas(currentDate);
      });

      // Función para cargar las reservas para una fecha dada
      //function cargarReservas(fecha) {
      // Aquí puedes realizar la lógica para cargar las reservas correspondientes a la fecha dada
      // Por ejemplo, puedes hacer una solicitud AJAX al servidor para obtener las reservas del día.
      // Una vez que obtengas las reservas, actualiza la tabla u otro elemento en tu interfaz.
      //}
    </script>

    <div class="container-fluid">
      <div class="row">
        <!-- Mostrar lista de reservas -->
        <div class="col-md-6">
          <?php
          echo "<table border='1'>";
          echo "<tr><th>Nombre</th><th>Mesa</th><th>Hora</th><th>Comensales</th></tr>";

          // Iterar sobre cada reserva
          foreach ($reservas as $reserva) {
            echo "<tr>";
            echo "<td>" . $reserva['nombre'] . "</td>";
            echo "<td>" . $reserva['mesa'] . "</td>";
            echo "<td>" . $reserva['hora'] . "</td>";
            echo "<td>" . $reserva['personas'] . "</td>";
            echo "</tr>";
          }

          echo "</table>";
          ?>
        </div>

        <!-- Mostrar detalles de la reserva seleccionada -->
        <div class="col-md-6">
          <h2>Detalles de Reserva</h2>
          <div class="col-md-6">
            <div class="reserva-card">
              <div class="info">
                <p><strong>Nombre:</strong> pablo</p>
                <p><strong>Teléfono:</strong> 9</p>
                <p><strong>Email:</strong> prueba</p>
                <p><strong>Mesa:</strong> 5</p>
                <p><strong>Fecha:</strong> 2024-04-09</p>
                <p><strong>Hora:</strong> 00:11:00</p>
                <p><strong>Personas:</strong> 5</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </section>
    <section id="nueva-reserva-section" class="active">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="form-container">
              <h2 class="text-center mb-4">NUEVA RESERVA</h2>
              <form method="POST" action="">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nombre">Nombre:</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Correo electrónico:</label>
                      <input type="email" class="form-control" id="email" name="email">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="telefono">Teléfono:</label>
                      <input type="tel" class="form-control" id="telefono" name="telefono">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="numpersonas">Número Comensales:</label>
                      <input type="text" class="form-control" id="numpersonas" name="numpersonas" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fecha">Fecha de reserva:</label>
                      <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="time">Hora:</label>
                      <input type="text" class="form-control" id="time" name="hora" placeholder="Seleccione la hora..."
                        required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="mesa">Mesa:</label>
                      <input type="text" class="form-control" id="mesa" name="mesa"
                        placeholder="Número o nombre de la mesa...">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="mensaje">Mensaje:</label>
                      <textarea class="form-control" id="mensaje" name="mensaje" rows="3"
                        placeholder="Añadir especificaciones"></textarea>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" id="submit" class="btn btn-primary"><strong>EFECTUAR RESERVA</strong></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section id="calendario-section">
      <h2>Calendario</h2>
      <p>Contenido de la sección de Calendario...</p>
    </section>
    <section id="clientes-section">
      <h2>Clientes</h2>
      <p>Contenido de la sección de Clientes...</p>
    </section>
    </div>
  </main>
  <!--Main layout-->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>


  <script>
    // Esperar a que el DOM esté completamente cargado
    $(document).ready(function () {
      // Manejar clic en elementos del sidebar
      $('.list-group-item').click(function () {
        $('.list-group-item').removeClass('active');
        $(this).addClass('active');

        // Obtener el ID de la sección relacionada
        var target = $(this).attr('href');

        // Ocultar todas las secciones
        $('section').removeClass('active');

        // Mostrar solo la sección relacionada
        $(target).addClass('active');
      });
    });

    flatpickr("#time", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i",
    });
  </script>
  <script>
    // Esperar a que el DOM esté completamente cargado
    $(document).ready(function () {
      // Ocultar la sección de nueva reserva y mostrar la sección de reservas al cargar la página
      $('#nueva-reserva-section').removeClass('active');
      $('#reservas-section').addClass('active');
    });
  </script>
</body>

</html>