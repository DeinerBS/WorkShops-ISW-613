<?php
// La primera parte de la ruta indica en qué sección estamos 
$section = explode('/', $_GET['route'] ?? '')[0];
?>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a href="<?php echo url('dashboard'); ?>" class="nav-link <?php echo $section === 'dashboard' ? 'active' : ''; ?>">Inicio</a>
    </li>
    <li class="nav-item">
      <a href="<?php echo url('profile'); ?>" class="nav-link <?php echo $section === 'profile' ? 'active' : ''; ?>">Perfil</a>
    </li>
    <li class="nav-item">
      <a href="<?php echo url('courses'); ?>" class="nav-link <?php echo $section === 'courses' ? 'active' : ''; ?>">Cursos</a>
    </li>
    <li class="nav-item">
      <a href="<?php echo url('users'); ?>" class="nav-link <?php echo $section === 'users' ? 'active' : ''; ?>">Usuarios</a>
    </li>
    <li class="nav-item ml-auto">
      <form action="<?php echo url('auth/logout'); ?>" method="POST" class="m-0">
        <button type="submit" class="nav-link btn btn-link">Cerrar sesión</button>
      </form>
    </li>
  </ul>