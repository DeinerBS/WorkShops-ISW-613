<?php
// Menú de navegación compartido
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$coursePages = ['courses.php', 'course_form.php'];
?>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a href="/pages/dashboard.php" class="nav-link <?php echo $currentPage === 'dashboard.php' ? 'active' : ''; ?>">Inicio</a>
    </li>
    <li class="nav-item">
      <a href="/pages/profile.php" class="nav-link <?php echo $currentPage === 'profile.php' ? 'active' : ''; ?>">Perfil</a>
    </li>
    <li class="nav-item">
      <a href="/pages/courses.php" class="nav-link <?php echo in_array($currentPage, $coursePages, true) ? 'active' : ''; ?>">Cursos</a>
    </li>
    <li class="nav-item ml-auto">
      <form action="/actions/logout.php" method="POST" class="m-0">
        <button type="submit" class="nav-link btn btn-link">Cerrar sesión</button>
      </form>
    </li>
  </ul>