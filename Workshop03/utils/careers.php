<?php

/**
 * Devuelve todas las carreras, cada una con las claves 'id' y 'name'
 * @param PDO $conn La conexión a la base de datos
 * @return array Un arreglo de arreglos asociativos, uno por carrera
 */
function getCareers(PDO $conn)
{
    return $conn->query('SELECT id, name FROM careers ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Busca una carrera por su id
 * @param PDO $conn La conexión a la base de datos
 * @param int $careerId El id de la carrera
 * @return array|false La carrera encontrada, o false si no existe
 */
function findCareer(PDO $conn, $careerId)
{
    $statement = $conn->prepare('SELECT id, name FROM careers WHERE id = :id LIMIT 1');
    $statement->execute(['id' => $careerId]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}