<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Province.php';

class AuthController extends Controller
{
    // Muestra el formulario de login 
    public function loginForm()
    {
        $rememberedUsername = $_COOKIE[REMEMBER_COOKIE] ?? '';

        $this->render('auth/login', [
            'title' => 'Login',
            'rememberedUsername' => $rememberedUsername,
        ]);
    }

    // Procesa el login
    public function login()
    {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        if (
            !is_string($username)
            || !is_string($password)
            || trim($username) === ''
            || strlen($username) > 50
            || $password === ''
        ) {
            redirect('auth/login', ['error' => 'invalid_input']);
        }

        $user = false;
        try {
            $userModel = new User($this->conn);
            $user = $userModel->findByUsername(trim($username));
        } catch (PDOException $exception) {
            error_log('Authentication database error: ' . $exception->getMessage());
        }

        // Si el usuario no existe o la contraseña no coincide mismo mensaje
        if ($user === false || !password_verify($password, $user['password_hash'])) {
            redirect('auth/login', ['error' => 'invalid_credentials']);
        }

        loginUser($user);

        // "Remember me": guarda el username en una cookie por 30 días, o la borra si no se marcó
        if (isset($_POST['remember_me'])) {
            rememberUsername($user['username']);
        } else {
            forgetUsername();
        }

        redirect('dashboard');
    }

    // Muestra el formulario de registro 
    public function registerForm()
    {
        $provinceModel = new Province($this->conn);

        $this->render('auth/register', [
            'title' => 'Sign up',
            'provinces' => $provinceModel->all(),
        ]);
    }

    // Procesa el registro 
    public function register()
    {
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
            redirect('auth/register', ['error' => 'invalid_input']);
        }

        if (strlen($password) < 8) {
            redirect('auth/register', ['error' => 'password_too_short']);
        }

        if ($password !== $confirmPassword) {
            redirect('auth/register', ['error' => 'password_mismatch']);
        }

        try {
            $provinceModel = new Province($this->conn);
            if ($provinceModel->find((int) $provinceId) === false) {
                redirect('auth/register', ['error' => 'invalid_province']);
            }

            $userModel = new User($this->conn);
            $userModel->create(trim($username), password_hash($password, PASSWORD_DEFAULT), (int) $provinceId);
        } catch (PDOException $exception) {
            // 23000 = violación de una restricción (el username es único)
            if ($exception->getCode() === '23000') {
                redirect('auth/register', ['error' => 'username_taken']);
            }

            error_log('Registration database error: ' . $exception->getMessage());
            redirect('auth/register', ['error' => 'server_error']);
        }

        redirect('auth/login', ['success' => 'registered']);
    }

    // Cierra la sesión
    public function logout()
    {
        logoutUser();
        redirect('auth/login', ['success' => 'logged_out']);
    }
}