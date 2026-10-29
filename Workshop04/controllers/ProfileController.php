<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Province.php';
require_once __DIR__ . '/../core/profile_pictures.php';

class ProfileController extends Controller
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);

        // El perfil solo es accesible con una sesión válida y activa
        requireLogin();
    }

    // Muestra el perfil y el formulario para actualizarlo 
    public function show()
    {
        $provinceModel = new Province($this->conn);

        $this->render('profile/show', [
            'title' => 'Profile',
            
            'user' => [
                'username' => $_SESSION['username'],
                'province_id' => $_SESSION['province_id'],
                'province_name' => $_SESSION['province_name'],
                'profile_picture' => $_SESSION['profile_picture'],
            ],
            'provinces' => $provinceModel->all(),
        ]);
    }

    // Procesa la actualización del perfil 
    public function update()
    {
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
            redirect('profile', ['error' => 'invalid_input']);
        }

        $username = trim($username);
        $changePassword = $newPassword !== '';
        $changePicture = is_array($picture) && ($picture['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
        $passwordHash = null;
        $newPicture = null;
        $oldPicture = null;

        if ($changePassword && strlen($newPassword) < 8) {
            redirect('profile', ['error' => 'password_too_short']);
        }

        if ($changePassword && $newPassword !== $confirmPassword) {
            redirect('profile', ['error' => 'password_mismatch']);
        }

        $userModel = new User($this->conn);
        $provinceModel = new Province($this->conn);
        $userId = $_SESSION['user_id'];

        try {
            $province = $provinceModel->find((int) $provinceId);
            if ($province === false) {
                redirect('profile', ['error' => 'invalid_province']);
            }

            // Cambiar la contraseña exige confirmar la actual
            if ($changePassword) {
                $currentHash = $userModel->getPasswordHash($userId);

                if ($currentHash === false || !password_verify($currentPassword, $currentHash)) {
                    redirect('profile', ['error' => 'wrong_password']);
                }

                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            }

            // La foto se guarda al final, cuando ya pasaron las demás validaciones
            if ($changePicture) {
                $oldPicture = $userModel->getProfilePicture($userId) ?: null;

                $upload = storeProfilePicture($picture);
                if (isset($upload['error'])) {
                    redirect('profile', ['error' => $upload['error']]);
                }

                $newPicture = $upload['filename'];
            }

            $userModel->updateProfile($userId, $username, (int) $province['id'], $passwordHash, $newPicture);
        } catch (PDOException $exception) {
            if ($newPicture !== null) {
                deleteProfilePicture($newPicture);
            }

            // 23000 = violación de una restricción el username es único
            if ($exception->getCode() === '23000') {
                redirect('profile', ['error' => 'username_taken']);
            }

            error_log('Profile update database error: ' . $exception->getMessage());
            redirect('profile', ['error' => 'server_error']);
        }

        // Mantenemos la sesión sincronizada con los datos nuevos
        $_SESSION['username'] = $username;
        $_SESSION['province_id'] = (int) $province['id'];
        $_SESSION['province_name'] = $province['name'];

        if ($newPicture !== null) {
            deleteProfilePicture($oldPicture);
            $_SESSION['profile_picture'] = $newPicture;
        }

        // Si el usuario tenía activado Remember me, actualizamos también la cookie
        if (isset($_COOKIE[REMEMBER_COOKIE])) {
            rememberUsername($username);
        }

        redirect('profile', ['success' => 'updated']);
    }
}