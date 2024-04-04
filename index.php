<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ingazu - Reservas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-YAXvad1EGLFb0KHe50KZzScx0MzWoxg4nOpg/J+Ls4bG7M8ap5rvH4/ZHLJUcV+k" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-jkqpKtBsveK7HRd4LSeET0OVR3fLGb0EcgFZBsu62ACUyFuWavj+mgxCJcpw4bf5" crossorigin="anonymous"></script>
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
  padding: 58px 0 0; /* Height of navbar */
  box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
  width: 240px;
  z-index: 600;
}

@media (max-width: 991.98px) {
  .sidebar {
    width: 100%;
  }
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
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
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
            <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                <i class="icon ion-md-add-circle lead mr-2"></i><span> Nueva Reserva</span></a>
            <a href="#" class="list-group-item list-group-item-action py-2 ripple active" aria-current="true">
                <i class="icon ion-md-list-box lead mr-2"></i><span> Reservas</span>
          </a>
          <a href="#" class="list-group-item list-group-item-action py-2 ripple">
            <i class="icon ion-md-calendar lead mr-2"></i><span> Calendario</span></a>
          <a href="#" class="list-group-item list-group-item-action py-2 ripple">
            <i class="icon ion-md-person lead mr-2"></i><span> Clientes</span></a>
        </div>
      </div>
    </nav>
    <!-- Sidebar -->
  
    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse" 
      data-bs-target="#sidebarMenu"
      aria-controls="sidebarMenu"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Brand -->
    <a class="navbar-brand" href="#">
      <img
        src="peque-logo_1.webp.png"
        height="25"
        alt="Ingazu Logo"
        loading="lazy"
      />
    </a>
    <!-- TITLE WEB -->
    <p class="d-none d-md-flex input-group w-auto my-auto">Gestión de Reservas - Ingazu
    </p>

    <!-- Right links -->
    <ul class="navbar-nav ms-auto d-flex flex-row">
      <!-- Avatar dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link text-dark dropdown-toggle" href="#" id="navbarDropdown" role="button"
          data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <!-- Cambiado de data-toggle a data-bs-toggle -->
          DROPDOWN
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Mi perfil</a>
          <a class="dropdown-item" href="#">Suscripciones</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Cerrar sesión</a>
        </div>
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
    <div class="container pt-4"></div>
  </main>
  <!--Main layout-->
</body>
</html>
