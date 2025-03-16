<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
session_start(); // Démarre la session
require 'db.php'; // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe
    $sql = "SELECT * FROM Users WHERE login = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            header("Location: dashboard.php"); // Redirection après connexion
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Login incorrect.";
    }
}
?>

<!-- Formulaire de connexion -->
<form method="POST" action="login.php" autocomplete="off">
    <input type="text" name="login" placeholder="Login" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
</body>
</html>