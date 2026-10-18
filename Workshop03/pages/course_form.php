<?php
require_once __DIR__ . '/../utils/auth.php';

requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';
require_once __DIR__ . '/../utils/messages.php';

$careers = getCareers($conn);

// Si viene ?id=... estamos editando; si no, estamos creando un curso nuevo
$course = null;
$courseId = $_GET['id'] ?? null;

if ($courseId !== null) {
    if (!is_string($courseId) || !ctype_digit($courseId)) {
        header('Location: /pages/courses.php?error=invalid_course');
        exit;
    }

    $course = findCourse($conn, (int) $courseId);
    if ($course === false) {
        header('Location: /pages/courses.php?error=course_not_found');
        exit;
    }
}

$isEdit = $course !== null;

// Valores que se muestran en el formulario 
$values = [
    'name' => $course['name'] ?? '',
    'code' => $course['code'] ?? '',
    'career_id' => $course['career_id'] ?? '',
    'credits' => $course['credits'] ?? '',
    'description' => $course['description'] ?? '',
];
?>
<?php require_once __DIR__ . '/common/header.php'; ?>
<body>
  <?php require_once __DIR__ . '/common/nav.php'; ?>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4><?php echo $isEdit ? 'Editar Curso' : 'Crear Curso'; ?></h4>
          </div>
          <div class="card-body">
            <?php renderAlert(); ?>
            <form action="<?php echo $isEdit ? '/actions/update_course.php' : '/actions/create_course.php'; ?>" method="POST">
              <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
              <?php endif; ?>
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="100"
                  value="<?php echo htmlspecialchars($values['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
              </div>
              <div class="form-group">
                <label for="code">Código de Curso</label>
                <input type="text" class="form-control" id="code" name="code" maxlength="20"
                  value="<?php echo htmlspecialchars($values['code'], ENT_QUOTES, 'UTF-8'); ?>" required>
              </div>
              <div class="form-group">
                <label for="career_id">Carrera</label>
                <select class="form-control" id="career_id" name="career_id" required>
                  <option value="" disabled <?php echo $values['career_id'] === '' ? 'selected' : ''; ?>>Seleccione una carrera</option>
                  <?php foreach ($careers as $career): ?>
                    <option value="<?php echo (int) $career['id']; ?>" <?php echo (int) $career['id'] === (int) $values['career_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($career['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="credits">Créditos</label>
                <input type="number" class="form-control" id="credits" name="credits" min="1" max="20"
                  value="<?php echo htmlspecialchars((string) $values['credits'], ENT_QUOTES, 'UTF-8'); ?>" required>
              </div>
              <div class="form-group">
                <label for="description">Descripción del Curso</label>
                <textarea class="form-control" id="description" name="description" rows="4" maxlength="1000"><?php echo htmlspecialchars($values['description']); ?></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-block"><?php echo $isEdit ? 'Guardar cambios' : 'Crear Curso'; ?></button>
            </form>
            <a href="/pages/courses.php" class="btn btn-link btn-block">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require_once __DIR__ . '/common/footer.php'; ?>