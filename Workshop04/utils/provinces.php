<?php

/**
 * Returns an array of all provinces, each with 'id' and 'name' keys
 * @param PDO $conn The database connection
 * @return array An array of associative arrays, each representing a province
 */
function getProvinces(PDO $conn) {
    return $conn->query('SELECT id, name FROM provinces ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Finds a province by its ID
 * @param PDO $conn The database connection
 * @param int $provinceId The ID of the province to find
 * @return array|null An associative array with 'id' and 'name' keys if found, or null if not found
 */
function findProvince(PDO $conn, $provinceId)
{
    $statement = $conn->prepare('SELECT id, name FROM provinces WHERE id = :id LIMIT 1');
    $statement->execute(['id' => $provinceId]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}
