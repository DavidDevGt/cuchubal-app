<?php
// Obtén la ruta actual desde la URL
$currentPath = $_SERVER['REQUEST_URI'];

// Define las rutas de las páginas que deseas resaltar como activas
$dashboardPath = '/cuchubal-app/frontend/';
$cuchubalesPath = '/cuchubal-app/frontend/cuchubales';
$pagosPath = '/cuchubal-app/frontend/pagos';
$participantesPath = '/cuchubal-app/frontend/participantes';
$usuariosPath = '/cuchubal-app/frontend/usuarios';

// Define una función para verificar si una ruta está activa
function isActive($currentPath, $targetPath) {
    return ($currentPath === $targetPath) ? 'active' : '';
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-0 py-3">
  <div class="container-xl">
    <!-- Logo -->
    <a class="navbar-brand" href="#">
      <img
        src="img/logo1.png"
        class="h-8"
        alt="Cuchubal App Logo"
        height="50"
        width="50"
        loading="lazy"
      />
      Cuchubal App
    </a>
    <!-- Navbar toggle -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarCollapse"
      aria-controls="navbarCollapse"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <!-- Nav -->
      <div class="navbar-nav mx-lg-auto">
        <a class="nav-item nav-link <?php echo isActive($currentPath, $dashboardPath); ?>" href="<?php echo $dashboardPath; ?>" aria-current="page">Dashboard</a>
        <a class="nav-item nav-link <?php echo isActive($currentPath, $cuchubalesPath); ?>" href="<?php echo $cuchubalesPath; ?>">Cuchubales</a>
        <a class="nav-item nav-link <?php echo isActive($currentPath, $pagosPath); ?>" href="<?php echo $pagosPath; ?>">Pagos</a>
        <a class="nav-item nav-link <?php echo isActive($currentPath, $participantesPath); ?>" href="<?php echo $participantesPath; ?>">Participantes</a>
        <a class="nav-item nav-link <?php echo isActive($currentPath, $usuariosPath); ?>" href="<?php echo $usuariosPath; ?>">Usuarios</a>
      </div>
      <!-- Right navigation -->
      <div class="navbar-nav ms-lg-4">
        <a class="nav-item nav-link" href="#">Mi Perfil</a>
      </div>
      <!-- Action -->
      <div class="d-flex align-items-lg-center mt-3 mt-lg-0">
        <a href="#" class="btn btn-sm btn-danger w-full w-lg-auto">
          Cerrar Sesión
        </a>
      </div>
    </div>
  </div>
</nav>
