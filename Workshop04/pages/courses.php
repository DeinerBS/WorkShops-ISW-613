<?php
require_once __DIR__ . '/../utils/auth.php';

// Solo se puede entrar con una sesión válida y activa
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/messages.php';

$courses = getCourses($conn);
?>
<?php require_once __DIR__ . '/common/header.php'; ?>
<body>
  <?php require_once __DIR__ . '/common/nav.php'; ?>
  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Cursos</h2>
      <a href="/pages/course_form.php" class="btn btn-primary">Crear Curso</a>
    </div>

    <?php renderAlert(); ?>

    <?php if (count($courses) === 0): ?>
      <div class="alert alert-info">No hay cursos registrados todavía.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>Nombre</th>
              <th>Código</th>
              <th>Id de la Carrera</th>
              <th>Créditos</th>
              <th>Descripción</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($courses as $course): ?>
              <tr>
                <td><?php echo htmlspecialchars($course['name']); ?></td>
                <td><?php echo htmlspecialchars($course['code']); ?></td>
                <td>
                  <?php echo (int) $course['career_id']; ?>
                  <small class="text-muted">(<?php echo htmlspecialchars($course['career_name'] ?? ''); ?>)</small>
                </td>
                <td><?php echo (int) $course['credits']; ?></td>
                <td><?php echo htmlspecialchars($course['description'] ?? ''); ?></td>
                <td class="text-nowrap">
                  <a href="/pages/course_form.php?id=<?php echo (int) $course['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                  <!-- Eliminar usa un formulario con método POST, no un enlace -->
                  <form action="/actions/delete_course.php" method="POST" class="d-inline"
                    onsubmit="return confirm('¿Seguro que desea eliminar este curso?');">
                    <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
<?php require_once __DIR__ . '/common/footer.php'; ?>