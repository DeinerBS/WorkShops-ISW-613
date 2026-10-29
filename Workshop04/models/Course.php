<?php

class Course
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    // Todos los cursos, con el nombre de su carrera
    public function all()
    {
        return $this->conn->query(
            'SELECT c.id, c.name, c.code, c.career_id, ca.name AS career_name, c.credits, c.description
             FROM courses c
             LEFT JOIN careers ca ON ca.id = c.career_id
             ORDER BY c.name'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    // Un curso por su id, false si no existe
    public function find($courseId)
    {
        $statement = $this->conn->prepare(
            'SELECT id, name, code, career_id, credits, description FROM courses WHERE id = :id LIMIT 1'
        );
        $statement->execute(['id' => $courseId]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Inserta un curso nuevo. $data: name, code, career_id, credits, description
    public function create(array $data)
    {
        $statement = $this->conn->prepare(
            'INSERT INTO courses (name, code, career_id, credits, description)
             VALUES (:name, :code, :career_id, :credits, :description)'
        );
        $statement->execute($data);
    }

    // Actualiza un curso existente. $data: name, code, career_id, credits, description
    public function update($courseId, array $data)
    {
        $data['id'] = $courseId;

        $statement = $this->conn->prepare(
            'UPDATE courses
             SET name = :name, code = :code, career_id = :career_id,
                 credits = :credits, description = :description
             WHERE id = :id'
        );
        $statement->execute($data);
    }

    // Elimina un curso.
    public function delete($courseId)
    {
        $statement = $this->conn->prepare('DELETE FROM courses WHERE id = :id');
        $statement->execute(['id' => $courseId]);
        return $statement->rowCount();
    }
}