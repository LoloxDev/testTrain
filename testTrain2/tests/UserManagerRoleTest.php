<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/UserManager.php';

class UserManagerRoleTest extends TestCase
{
    private UserManager $userManager;

    public function testAddUserWithRole()
    {
        // Test de l'ajout d'un utilisateur avec un rôle personnalisé
        $this->userManager->addUser("AliceRole", "alice-role@example.com", "admin");
        $users = $this->userManager->getUsers();

        $this->assertCount(1, $users);
        $this->assertEquals("AliceRole", $users[0]['name']);
        $this->assertEquals("alice-role@example.com", $users[0]['email']);
        $this->assertEquals("admin", $users[0]['role']);
    }

    public function testUpdateUserRole()
    {
        // On ajoute d'abord l'utilisateur avec le rôle 'user'
        $this->userManager->addUser("BobRole", "bob-role@example.com", "user");
        $users = $this->userManager->getUsers();
        $this->assertCount(1, $users);

        $userId = $users[0]['id'];
        // Mise à jour : on passe le rôle à 'admin'
        $this->userManager->updateUser($userId, "BobRole", "bob-role@example.com", "admin");

        $updatedUser = $this->userManager->getUser($userId);
        $this->assertEquals("admin", $updatedUser['role']);
    }

    protected function setUp(): void
    {
        $this->userManager = new UserManager();
        // On vide la table avant chaque test pour repartir d'une base propre
        $this->userManager->db->exec("DELETE FROM users");
    }
}
