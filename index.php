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

$fecha_actual = date('Y-m-d');

// Consultar todas las reservas
$sql = "SELECT * FROM reserva WHERE fecha = '$fecha_actual'";
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

  // Preparar la consulta SQL para insertar la reserva
  $sql_insert = "INSERT INTO reserva (nombre, email, telefono, personas, fecha, hora, mesa, mensaje) 
  VALUES ('$nombre', '$email', '$telefono', '$numpersonas', '$fecha', '$hora', '$mesa', '$mensaje')";

  // Ejecutar la consulta
  if ($conn->query($sql_insert) === TRUE) {
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
  } else {
    echo "<script>alert('Error al crear la reserva: " . $conn->error . "');</script>";
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

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

    .reserva-card {
      max-width: 400px;
      margin: 0 auto;
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

    #prevDay,
    #nextDay {
      width: 40px;
      background-color: blue;
      color: yellow;
      /* Ajusta el ancho según sea necesario */
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
        <a class="navbar-brand" href="index.php">
          <img src="peque-logo_1.webp.png" height="25" alt="Ingazu Logo" loading="lazy" />
        </a>
        <!-- TITLE WEB -->
        <p class="d-none d-md-flex input-group w-auto my-auto">Gestión de Reservas - Ingazu </p>

        <!-- Right links -->
        <ul class="navbar-nav ms-auto d-flex flex-row">
          <!-- Avatar -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
              id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="peque-logo_1.webp.png" class="rounded-circle" height="22" alt="Avatar" loading="lazy" />
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#">Mi perfil</a></li>
              <li><a class="dropdown-item" href="#">Configuración</a></li>
              <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->

  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main style="margin-top: 58px;">
    <div class="container pt-4">
      <!-- Contenido de las secciones -->
      <section id="nueva-reserva-section">
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
                        <input type="text" class="form-control" id="time" name="hora"
                          placeholder="Seleccione la hora..." required>
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
      <section id="reservas-section" class="active">
        <div class="d-flex justify-content-center align-items-center my-3">
          <button id="prevDay" class="btn btn-secondary me-2"><</button>
          <input type="date" id="reservaFecha" class="form-control mx-2" style="max-width: 200px;"
            value="<?php echo $fecha_actual; ?>">
          <button id="nextDay" class="btn btn-secondary ms-2">></button>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div id="reservasTableContainer">
              <!-- Aquí se mostrará la tabla con todas las reservas -->
            </div>
          </div>
          <div class="col-md-6">
            <div id="reservaCardContainer">
              <!-- Aquí se mostrará la tarjeta de información de la reserva seleccionada -->
            </div>
          </div>
        </div>
      </section>
      <section id="calendario-section">
        <h2>Calendario</h2>
        <!-- Contenido del calendario -->
      </section>
      <section id="clientes-section">
        <h2>Clientes</h2>
        <!-- Contenido de clientes -->
      </section>
    </div>
  </main>
  <!--Main layout-->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function () {
      // Función para actualizar la tabla de reservas
      function updateReservas(fecha) {
        $.ajax({
          url: 'get_reservas.php',
          type: 'GET',
          data: { fecha: fecha },
          success: function (response) {
            $('#reservasTableContainer').html(response);
            // Asignar evento de clic a cada fila de la tabla para mostrar la tarjeta de reserva
            $('#reservasTableContainer table tr').on('click', function () {
              const reservaId = $(this).data('id');
              showReservaCard(reservaId);
            });
          },
          error: function () {
            $('#reservasTableContainer').html('<p>Error al cargar las reservas.</p>');
          }
        });
      }

      // Función para mostrar la tarjeta de información de la reserva seleccionada
      function showReservaCard(reservaId) {
        console.log("reserva id:"+reservaId);
        $.ajax({
          url: 'get_reserva.php',
          type: 'GET',
          data: { id: reservaId },
          success: function (response) {
            $('#reservaCardContainer').html(response);
          },
          error: function () {
            $('#reservaCardContainer').html('<p>Error al cargar la información de la reserva.</p>');
          }
        });
      }

      // Cargar las reservas iniciales para la fecha actual
      let fechaActual = $('#reservaFecha').val();
      updateReservas(fechaActual);

      // Actualizar reservas cuando se cambie la fecha
      $('#reservaFecha').on('change', function () {
        updateReservas($(this).val());
      });

      // Navegar entre días con los botones
      $('#prevDay').on('click', function () {
        let currentDate = new Date($('#reservaFecha').val());
        currentDate.setDate(currentDate.getDate() - 1);
        let newDate = currentDate.toISOString().split('T')[0];
        $('#reservaFecha').val(newDate);
        updateReservas(newDate);
      });

      $('#nextDay').on('click', function () {
        let currentDate = new Date($('#reservaFecha').val());
        currentDate.setDate(currentDate.getDate() + 1);
        let newDate = currentDate.toISOString().split('T')[0];
        $('#reservaFecha').val(newDate);
        updateReservas(newDate);
      });

      // Mostrar la sección correspondiente al hacer clic en un enlace del menú
      $('a.list-group-item').on('click', function (e) {
        e.preventDefault();
        $('a.list-group-item').removeClass('active');
        $(this).addClass('active');
        const target = $(this).attr('href');
        $('section').removeClass('active');
        $(target).addClass('active');
      });
    });
  </script>
</body>

</html>