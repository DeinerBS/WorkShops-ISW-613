<?php
// $course es null al crear, o el curso completo al editar
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
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4><?php echo $isEdit ? 'Editar Curso' : 'Crear Curso'; ?></h4>
          </div>
          <div class="card-body">
            <?php renderAlert(); ?>
            <form action="<?php echo $isEdit ? url('courses/update') : url('courses/store'); ?>" method="POST">
              <?php if ($isEdit): ?>
                <input type="hidden" name="id" value="<?php echo (int) $course['id']; ?>">
              <?php endif; ?>
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="100"
                  value="<?php echo e($values['name']); ?>" required>
              </div>
              <div class="form-group">
                <label for="code">Código de Curso</label>
                <input type="text" class="form-control" id="code" name="code" maxlength="20"
                  value="<?php echo e($values['code']); ?>" required>
              </div>
              <div class="form-group">
                <label for="career_id">Carrera</label>
                <select class="form-control" id="career_id" name="career_id" required>
                  <option value="" disabled <?php echo $values['career_id'] === '' ? 'selected' : ''; ?>>Seleccione una carrera</option>
                  <?php foreach ($careers as $career): ?>
                    <option value="<?php echo (int) $career['id']; ?>" <?php echo (int) $career['id'] === (int) $values['career_id'] ? 'selected' : ''; ?>><?php echo e($career['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="credits">Créditos</label>
                <input type="number" class="form-control" id="credits" name="credits" min="1" max="20"
                  value="<?php echo e($values['credits']); ?>" required>
              </div>
              <div class="form-group">
                <label for="description">Descripción del Curso</label>
                <textarea class="form-control" id="description" name="description" rows="4" maxlength="1000"><?php echo e($values['description']); ?></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-block"><?php echo $isEdit ? 'Guardar cambios' : 'Crear Curso'; ?></button>
            </form>
            <a href="<?php echo url('courses'); ?>" class="btn btn-link btn-block">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
  </div>