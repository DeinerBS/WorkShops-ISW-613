<?php

$dsn = 'mysql:host=127.0.0.1;dbname=iswapp;charset=utf8mb4';
$dbUser = 'root';
$dbPassword = 'root';

try {
    $conn = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $exception) {
    // Log the details instead of showing them: an uncaught error would print the credentials in the stack trace
    error_log('Database connection error: ' . $exception->getMessage());
    http_response_code(500);
    exit('The service is temporarily unavailable. Please try again later.');
}
