<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'ID de l'utilisateur est passé dans l'URL
if (!isset($_GET['id'])) {
    echo "ID de l'utilisateur non spécifié.";
    exit();
}

$user_id = $_GET['id'];

// Supprimer l'utilisateur de la base de données
$sql = "DELETE FROM Users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    echo "Utilisateur supprimé avec succès.";
} else {
    echo "Erreur de suppression.";
}

header("Location: users.php");  // Rediriger vers la liste des utilisateurs
exit();