<?php

class DashboardController extends Controller
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);

        // Solo con sesión activa
        requireLogin();
    }

    public function index()
    {
        $this->render('dashboard', [
            'title' => 'Dashboard',
            'username' => $_SESSION['username'],
        ]);
    }
}