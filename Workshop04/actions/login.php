<?php
require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/auth.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

// validates the input to ensure that the username and password are strings, not empty, and within reasonable length limits
if (
    !is_string($username)
    || !is_string($password)
    || trim($username) === ''
    || strlen($username) > 50
    || $password === ''
) {
    //redirect to login page with error message
    header('Location: /index.php?error=invalid_input');
    exit;
}


$user = false;
try {
    // connect to the database and fetch the user record along with its province
    $statement = $conn->prepare(
        'SELECT u.id, u.username, u.password_hash, u.province_id, u.profile_picture, p.name AS province_name
         FROM users u
         LEFT JOIN provinces p ON p.id = u.province_id
         WHERE u.username = :username
         LIMIT 1'
    );
    $statement->execute(['username' => trim($username)]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    error_log('Authentication database error: ' . $exception->getMessage());
}

// check if the user exists and verify the password
if ($user === false || !password_verify($password, $user['password_hash'])) {
    // Invalid credentials redirect to login page with error message
    header('Location: /index.php?error=invalid_credentials');
    exit;
}

// Set session variables and redirect to dashboard
loginUser($user);

// "Remember me": store the username in a cookie for 30 days, or clear it if unchecked
if (isset($_POST['remember_me'])) {
    rememberUsername($user['username']);
} else {
    forgetUsername();
}

header('Location: /pages/dashboard.php');
