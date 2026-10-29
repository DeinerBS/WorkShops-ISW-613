<?php

class User
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    // Busca un usuario por username, junto con el nombre de su provincia 
    public function findByUsername($username)
    {
        $statement = $this->conn->prepare(
            'SELECT u.id, u.username, u.password_hash, u.province_id, u.profile_picture, p.name AS province_name
             FROM users u
             LEFT JOIN provinces p ON p.id = u.province_id
             WHERE u.username = :username
             LIMIT 1'
        );
        $statement->execute(['username' => $username]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Registra un usuario nuevo
    public function create($username, $passwordHash, $provinceId)
    {
        $statement = $this->conn->prepare(
            'INSERT INTO users (username, password_hash, province_id)
             VALUES (:username, :password_hash, :province_id)'
        );
        $statement->execute([
            'username' => $username,
            'password_hash' => $passwordHash,
            'province_id' => $provinceId,
        ]);
    }

    // Lista de todos los usuarios con su provincia
    public function getAll()
    {
        return $this->conn->query(
            'SELECT u.id, u.username, p.name AS province_name, u.created_at
             FROM users u
             LEFT JOIN provinces p ON p.id = u.province_id
             ORDER BY u.id'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hash de la contraseña de un usuario
    public function getPasswordHash($id)
    {
        $statement = $this->conn->prepare('SELECT password_hash FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetchColumn();
    }

    // Nombre del archivo de la foto de perfil actual o false/null si no tiene
    public function getProfilePicture($id)
    {
        $statement = $this->conn->prepare('SELECT profile_picture FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        return $statement->fetchColumn();
    }

    // Actualiza el perfil. La contraseña y la foto son opcionales null = no cambiarlas
    public function updateProfile($id, $username, $provinceId, $passwordHash = null, $profilePicture = null)
    {
        $fields = ['username' => $username, 'province_id' => $provinceId, 'id' => $id];
        $sql = 'UPDATE users SET username = :username, province_id = :province_id';

        if ($passwordHash !== null) {
            $sql .= ', password_hash = :password_hash';
            $fields['password_hash'] = $passwordHash;
        }

        if ($profilePicture !== null) {
            $sql .= ', profile_picture = :profile_picture';
            $fields['profile_picture'] = $profilePicture;
        }

        $statement = $this->conn->prepare($sql . ' WHERE id = :id');
        $statement->execute($fields);
    }
}