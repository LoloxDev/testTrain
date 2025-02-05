<?php
// tests/UserManagerTest.php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/UserManager.php';

class UserManagerTest extends TestCase
{
    /** @var UserManager */
    private $userManager;

    public function testAddUser()
    {
        $name = "John";
        $email = "john@example.com";
        $this->userManager->addUser($name, $email);
        $users = $this->userManager->getUsers();

        $this->assertNotEmpty($users);
        $this->assertEquals($name, $users[0]['name']);
        $this->assertEquals($email, $users[0]['email']);
    }

    public function testAddUserEmailException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->userManager->addUser("Invalid", "not-an-email");
    }

    public function testUpdateUser()
    {
        // Ajout d'un utilisateur
        $this->userManager->addUser("Jane", "jane@example.com");
        $users = $this->userManager->getUsers();
        $userId = $users[0]['id'];

        // Mise à jour
        $newName = "Jane Doe";
        $newEmail = "jane.doe@example.com";
        $this->userManager->updateUser($userId, $newName, $newEmail);

        $updatedUser = $this->userManager->getUser($userId);
        $this->assertEquals($newName, $updatedUser['name']);
        $this->assertEquals($newEmail, $updatedUser['email']);
    }

    public function testRemoveUser()
    {
        // Ajout d'un utilisateur
        $this->userManager->addUser("Mike", "mike@example.com");
        $users = $this->userManager->getUsers();
        $userId = $users[0]['id'];

        // Suppression
        $this->userManager->removeUser($userId);
        $usersAfterRemoval = $this->userManager->getUsers();
        $this->assertEmpty($usersAfterRemoval);
    }

    public function testGetUsers()
    {
        // Ajout de plusieurs utilisateurs
        $this->userManager->addUser("User1", "user1@example.com");
        $this->userManager->addUser("User2", "user2@example.com");
        $users = $this->userManager->getUsers();
        $this->assertCount(2, $users);
    }

    public function testInvalidUpdateThrowsException()
    {
        $this->expectException(Exception::class);
        $this->userManager->updateUser(999, "NonExistent", "nonexistent@example.com");
    }

    // Ces tests vérifient que la mise à jour ou la suppression d'un utilisateur inexistant génère une erreur.
    // **Note :** Dans le code fourni, les méthodes updateUser() et removeUser() n'émettent pas d'exception si l'utilisateur n'existe pas.
    // Pour que ces tests passent, il faudra ajouter une vérification du nombre de lignes affectées.

    public function testInvalidDeleteThrowsException()
    {
        $this->expectException(Exception::class);
        $this->userManager->removeUser(999);
    }

    protected function setUp(): void
    {
        $this->userManager = new UserManager();
        // On nettoie la table pour partir sur une base vide
        $this->userManager->db->exec("DELETE FROM users");
    }
}
