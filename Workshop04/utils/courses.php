<?php

require_once __DIR__ . '/careers.php';

/**
 * Devuelve todos los cursos junto con el nombre de su carrera
 * @param PDO $conn La conexión a la base de datos
 * @return array Un arreglo de arreglos asociativos, uno por curso
 */
function getCourses(PDO $conn)
{
    return $conn->query(
        'SELECT c.id, c.name, c.code, c.career_id, ca.name AS career_name, c.credits, c.description
         FROM courses c
         LEFT JOIN careers ca ON ca.id = c.career_id
         ORDER BY c.name'
    )->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Busca un curso por su id
 * @return array|false El curso encontrado, o false si no existe
 */
function findCourse(PDO $conn, $courseId)
{
    $statement = $conn->prepare(
        'SELECT id, name, code, career_id, credits, description FROM courses WHERE id = :id LIMIT 1'
    );
    $statement->execute(['id' => $courseId]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Inserta un curso nuevo
 * @param array $data Claves: name, code, career_id, credits, description
 */
function createCourse(PDO $conn, array $data)
{
    $statement = $conn->prepare(
        'INSERT INTO courses (name, code, career_id, credits, description)
         VALUES (:name, :code, :career_id, :credits, :description)'
    );
    $statement->execute($data);
}

/**
 * Actualiza un curso existente
 * @param array $data Claves: name, code, career_id, credits, description
 */
function updateCourse(PDO $conn, $courseId, array $data)
{
    $statement = $conn->prepare(
        'UPDATE courses
         SET name = :name, code = :code, career_id = :career_id,
             credits = :credits, description = :description
         WHERE id = :id'
    );
    $statement->execute($data + ['id' => $courseId]);
}

/**
 * Elimina un curso
 * @return int Cantidad de filas eliminadas 
 */
function deleteCourse(PDO $conn, $courseId)
{
    $statement = $conn->prepare('DELETE FROM courses WHERE id = :id');
    $statement->execute(['id' => $courseId]);
    return $statement->rowCount();
}

/**
 * Valida y limpia los datos que llegan del formulario de curso
 * @param array $input Normalmente $_POST
 * @return array ['data' => [...]] si todo está bien, o ['error' => 'codigo'] si no
 */
function validateCourseInput(PDO $conn, array $input)
{
    $name = $input['name'] ?? null;
    $code = $input['code'] ?? null;
    $careerId = $input['career_id'] ?? null;
    $credits = $input['credits'] ?? null;
    $description = $input['description'] ?? '';

    // Todos deben llegar como texto 
    if (
        !is_string($name)
        || !is_string($code)
        || !is_string($careerId)
        || !is_string($credits)
        || !is_string($description)
    ) {
        return ['error' => 'invalid_course_input'];
    }

    $name = trim($name);
    $code = mb_strtoupper(trim($code));
    $description = trim($description);

    if (
        $name === ''
        || mb_strlen($name) > 100
        || $code === ''
        || mb_strlen($code) > 20
        || mb_strlen($description) > 1000
        || !ctype_digit($credits)
        || (int) $credits < 1
        || (int) $credits > 20
    ) {
        return ['error' => 'invalid_course_input'];
    }

    // La carrera debe existir en la tabla careers
    if (!ctype_digit($careerId) || findCareer($conn, (int) $careerId) === false) {
        return ['error' => 'invalid_career'];
    }

    return [
        'data' => [
            'name' => $name,
            'code' => $code,
            'career_id' => (int) $careerId,
            'credits' => (int) $credits,
            'description' => $description === '' ? null : $description,
        ],
    ];
}