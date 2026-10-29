<?php

require_once __DIR__ . '/../models/User.php';

class UserController extends Controller
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);

        // La lista de usuarios solo es accesible con una sesión activa
        requireLogin();
    }

    // Muestra la lista de usuarios (GET)
    public function index()
    {
        $userModel = new User($this->conn);

        $this->render('users/index', [
            'title' => 'Users',
            'users' => $userModel->getAll(),
        ]);
    }
}