<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les utilisateurs depuis la base de données
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
?>
<div class=divaaa>
<h2 class="h2">Liste des utilisateurs</h2>
<div class="diva">
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Photo de profil</th>
        <th>Actions</th>
    </tr>

    <?php while ($user = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['nom']); ?></td>
            <td><?php echo htmlspecialchars($user['prenom']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
                <?php if (!empty($user['profile'])): ?>
                    <img src="<?php echo htmlspecialchars($user['profile']); ?>" width="50" height="50">
                <?php else: ?>
                    Aucune photo
                <?php endif; ?>
            </td>
            <td>
                <!--lien pour la modification-->
                <a href="modification.php?id=<?php echo $user['id']; ?>" title="Modifier">
                <i class="fa-solid fa-pen-to-square i" style="color: #4CAF50;"></i>
                </a>

                 <!--lien pour la suppression-->
                <a href="supression.php?id=<?php echo $user['id']; ?>" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                 <i class="fa-solid fa-trash i" style="color: #f44336;"></i>
                </a>

            </td>
        </tr>
    <?php endwhile; ?>
</table>
</div>
<div class="divaa">
<a href="user.php">Ajouter un utilisateur</a>
<br>
<a href="logout.php">Déconnexion</a>
</div>
</div>
</body>
</html>