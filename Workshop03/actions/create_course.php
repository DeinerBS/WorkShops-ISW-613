<?php
require_once __DIR__ . '/../utils/auth.php';

// Solo un usuario con sesión puede crear cursos
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';

//  solo aceptar peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/courses.php');
    exit;
}

$result = validateCourseInput($conn, $_POST);

if (isset($result['error'])) {
    header('Location: /pages/course_form.php?error=' . $result['error']);
    exit;
}

try {
    createCourse($conn, $result['data']);
} catch (PDOException $exception) {
    // 23000 = violación de una restricción, aquí, el código de curso repetido
    if ($exception->getCode() === '23000') {
        header('Location: /pages/course_form.php?error=course_code_taken');
        exit;
    }

    error_log('Create course database error: ' . $exception->getMessage());
    header('Location: /pages/course_form.php?error=server_error');
    exit;
}

// Curso creado, regresamos a la lista
header('Location: /pages/courses.php?success=course_created');
exit;