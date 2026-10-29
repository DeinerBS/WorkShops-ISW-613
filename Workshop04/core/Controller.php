<?php

abstract class Controller
{
    protected $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    // Muestra una vista dentro del layout.
    protected function render($view, array $data = [])
    {
        // extract convierte ['courses' => [...]] en la variable $courses para la vista
        extract($data);

        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/' . $view . '.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }
}