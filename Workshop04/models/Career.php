<?php

class Career
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    // Todas las carreras, cada una con id y name
    public function all()
    {
        return $this->conn->query('SELECT id, name FROM careers ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    // Una carrera por su id, false si no existe
    public function find($careerId)
    {
        $statement = $this->conn->prepare('SELECT id, name FROM careers WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $careerId]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}