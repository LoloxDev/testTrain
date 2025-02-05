<?php

class UserManager
{
    public PDO $db;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=testTrain;charset=utf8";
        $username = "root"; // Modifier si besoin
        $password = ""; // Modifier si besoin
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function addUser(string $name, string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide.");
        }

        $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);
    }

    public function removeUser(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        // Si aucune ligne n'est affectée, c'est que l'utilisateur n'existe pas
        if ($stmt->rowCount() === 0) {
            throw new Exception("Utilisateur introuvable.");
        }
    }

    public function getUsers(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUser(int $id): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        if (!$user) throw new Exception("Utilisateur introuvable.");
        return $user;
    }

    public function updateUser(int $id, string $name, string $email): void
    {
        $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->execute(['id' => $id, 'name' => $name, 'email' => $email]);

        // Si aucune ligne n'est affectée, c'est que l'utilisateur n'existe pas
        if ($stmt->rowCount() === 0) {
            throw new Exception("Utilisateur introuvable.");
        }
    }

}

?>
