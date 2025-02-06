<?php
require_once 'UserManager.php';
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$userManager = new UserManager();

try {
    if ($method === 'POST') {
        // POST => Ajouter un utilisateur
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $role = $_POST['role'] ?? 'user';

        if (!$name || !$email) {
            throw new Exception("Champs manquants (name/email).");
        }

        $userManager->addUser($name, $email, $role);
        echo json_encode(["message" => "Utilisateur ajouté avec succès"]);

    } elseif ($method === 'GET') {
        // GET => Récupération de la liste
        echo json_encode($userManager->getUsers());

    } elseif ($method === 'DELETE') {
        // DELETE => Suppression
        $id = $_GET['id'] ?? null;
        if (!$id) {
            throw new Exception("ID manquant pour la suppression.");
        }
        $userManager->removeUser($id);
        echo json_encode(["message" => "Utilisateur supprimé"]);

    } elseif ($method === 'PUT') {
        // PUT => Mise à jour
        parse_str(file_get_contents("php://input"), $_PUT);
        $id = $_PUT['id'] ?? null;
        $name = $_PUT['name'] ?? null;
        $email = $_PUT['email'] ?? null;
        $role = $_PUT['role'] ?? 'user';

        if (!$id || !$name || !$email) {
            throw new Exception("Champs manquants (id/name/email).");
        }

        $userManager->updateUser($id, $name, $email, $role);
        echo json_encode(["message" => "Utilisateur mis à jour"]);

    } else {
        throw new Exception("Requête invalide.");
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
}
