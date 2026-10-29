<?php
require_once __DIR__ . '/../utils/auth.php';

// Only a logged in user can update their profile
requireLogin();

require_once __DIR__ . '/../utils/database.php';
require_once __DIR__ . '/../utils/provinces.php';
require_once __DIR__ . '/../utils/profile_pictures.php';

$username = $_POST['username'] ?? null;
$provinceId = $_POST['province_id'] ?? null;
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$picture = $_FILES['profile_picture'] ?? null;

if (
    !is_string($username)
    || !is_string($currentPassword)
    || !is_string($newPassword)
    || !is_string($confirmPassword)
    || trim($username) === ''
    || strlen(trim($username)) > 50
    || !ctype_digit((string) $provinceId)
) {
    header('Location: /pages/profile.php?error=invalid_input');
    exit;
}

$username = trim($username);
$changePassword = $newPassword !== '';
// The picture is optional: an empty file input means "keep the current one"
$changePicture = is_array($picture) && ($picture['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
$newPicture = null;
$oldPicture = null;

if ($changePassword && strlen($newPassword) < 8) {
    header('Location: /pages/profile.php?error=password_too_short');
    exit;
}

if ($changePassword && $newPassword !== $confirmPassword) {
    header('Location: /pages/profile.php?error=password_mismatch');
    exit;
}

try {
    $province = findProvince($conn, (int) $provinceId);
    if ($province === false) {
        header('Location: /pages/profile.php?error=invalid_province');
        exit;
    }

    $fields = ['username' => $username, 'province_id' => (int) $province['id'], 'id' => $_SESSION['user_id']];
    $sql = 'UPDATE users SET username = :username, province_id = :province_id';

    // Changing the password requires confirming the current one
    if ($changePassword) {
        $statement = $conn->prepare('SELECT password_hash FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $_SESSION['user_id']]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user === false || !password_verify($currentPassword, $user['password_hash'])) {
            header('Location: /pages/profile.php?error=wrong_password');
            exit;
        }

        $sql .= ', password_hash = :password_hash';
        $fields['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    // Stored last, after every other check passed, so a rejected update leaves no orphan file behind
    if ($changePicture) {
        $statement = $conn->prepare('SELECT profile_picture FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $_SESSION['user_id']]);
        $oldPicture = $statement->fetchColumn() ?: null;

        $upload = storeProfilePicture($picture);
        if (isset($upload['error'])) {
            header('Location: /pages/profile.php?error=' . $upload['error']);
            exit;
        }

        $newPicture = $upload['filename'];
        $sql .= ', profile_picture = :profile_picture';
        $fields['profile_picture'] = $newPicture;
    }

    $statement = $conn->prepare($sql . ' WHERE id = :id');
    $statement->execute($fields);
} catch (PDOException $exception) {
    // The update did not happen, so the new picture is not referenced by anyone
    if ($newPicture !== null) {
        deleteProfilePicture($newPicture);
    }

    // 23000 = integrity constraint violation (the username unique key)
    if ($exception->getCode() === '23000') {
        header('Location: /pages/profile.php?error=username_taken');
        exit;
    }

    error_log('Profile update database error: ' . $exception->getMessage());
    header('Location: /pages/profile.php?error=server_error');
    exit;
}

// Keep the session in sync with the updated data
$_SESSION['username'] = $username;
$_SESSION['province_id'] = (int) $province['id'];
$_SESSION['province_name'] = $province['name'];

if ($newPicture !== null) {
    deleteProfilePicture($oldPicture);
    $_SESSION['profile_picture'] = $newPicture;
}

// Keep the "remember me" cookie in sync if the user had it enabled
if (isset($_COOKIE[REMEMBER_COOKIE])) {
    rememberUsername($username);
}

header('Location: /pages/profile.php?success=updated');
