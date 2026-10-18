<?php

function getUsers(PDO $conn)
{
    return $conn->query(
        'SELECT u.id, u.username, p.name AS province_name, u.created_at
         FROM users u
         LEFT JOIN provinces p ON p.id = u.province_id
         ORDER BY u.id'
    )->fetchAll(PDO::FETCH_ASSOC);
}
