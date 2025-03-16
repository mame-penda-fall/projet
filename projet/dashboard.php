<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
   
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="madiv">
    <?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "Bienvenue, " . $_SESSION['login'] . " !";
echo "<br><a href='users.php'>liste </a>";
echo "<br><a href='logout.php'>Déconnexion</a>";
?>
</div>
</body>
</html>