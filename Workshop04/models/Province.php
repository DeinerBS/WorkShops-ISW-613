<?php

class Province
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    // Todas las provincias, cada una con id y name
    public function all()
    {
        return $this->conn->query('SELECT id, name FROM provinces ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
    }

    // Una provincia por su id, false si no existe
    public function find($provinceId)
    {
        $statement = $this->conn->prepare('SELECT id, name FROM provinces WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $provinceId]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}