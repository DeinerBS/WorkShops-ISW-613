<?php
require_once __DIR__ . '/../utils/auth.php';

requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/courses.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pages/courses.php');
    exit;
}

$courseId = $_POST['id'] ?? null;

if (!is_string($courseId) || !ctype_digit($courseId)) {
    header('Location: /pages/courses.php?error=invalid_course');
    exit;
}

$courseId = (int) $courseId;

try {
    if (findCourse($conn, $courseId) === false) {
        header('Location: /pages/courses.php?error=course_not_found');
        exit;
    }

    $result = validateCourseInput($conn, $_POST);

    if (isset($result['error'])) {
        header('Location: /pages/course_form.php?id=' . $courseId . '&error=' . $result['error']);
        exit;
    }

    updateCourse($conn, $courseId, $result['data']);
} catch (PDOException $exception) {
    if ($exception->getCode() === '23000') {
        header('Location: /pages/course_form.php?id=' . $courseId . '&error=course_code_taken');
        exit;
    }

    error_log('Update course database error: ' . $exception->getMessage());
    header('Location: /pages/course_form.php?id=' . $courseId . '&error=server_error');
    exit;
}

header('Location: /pages/courses.php?success=course_updated');
exit;