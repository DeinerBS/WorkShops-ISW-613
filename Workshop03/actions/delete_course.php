<?php
require_once __DIR__ . '/../utils/auth.php';

requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';

// Eliminar solo se permite con POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/courses.php');
    exit;
}

$courseId = $_POST['id'] ?? null;

if (!is_string($courseId) || !ctype_digit($courseId)) {
    header('Location: /pages/courses.php?error=invalid_course');
    exit;
}

try {
    $deleted = deleteCourse($conn, (int) $courseId);
} catch (PDOException $exception) {
    error_log('Delete course database error: ' . $exception->getMessage());
    header('Location: /pages/courses.php?error=server_error');
    exit;
}

if ($deleted === 0) {
    header('Location: /pages/courses.php?error=course_not_found');
    exit;
}

header('Location: /pages/courses.php?success=course_deleted');
exit;