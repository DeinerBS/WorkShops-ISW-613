<?php
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/provinces.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$confirmPassword = $_POST['confirm_password'] ?? null;
$provinceId = $_POST['province_id'] ?? null;

if (
    !is_string($username)
    || !is_string($password)
    || !is_string($confirmPassword)
    || trim($username) === ''
    || strlen(trim($username)) > 50
    || !ctype_digit((string) $provinceId)
) {
    header('Location: /pages/register.php?error=invalid_input');
    exit;
}

if (strlen($password) < 8) {
    header('Location: /pages/register.php?error=password_too_short');
    exit;
}

if ($password !== $confirmPassword) {
    header('Location: /pages/register.php?error=password_mismatch');
    exit;
}

try {
    if (findProvince($conn, (int) $provinceId) === false) {
        header('Location: /pages/register.php?error=invalid_province');
        exit;
    }

    $statement = $conn->prepare(
        'INSERT INTO users (username, password_hash, province_id) VALUES (:username, :password_hash, :province_id)'
    );
    $statement->execute([
        'username' => trim($username),
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'province_id' => (int) $provinceId,
    ]);
} catch (PDOException $exception) {
    // 23000 = integrity constraint violation (the username unique key)
    if ($exception->getCode() === '23000') {
        header('Location: /pages/register.php?error=username_taken');
        exit;
    }

    error_log('Registration database error: ' . $exception->getMessage());
    header('Location: /pages/register.php?error=server_error');
    exit;
}

header('Location: /index.php?success=registered');
