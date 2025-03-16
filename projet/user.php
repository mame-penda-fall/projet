<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
   
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include 'db.php';

// Vérifier si le formulaire est soumis pour ajouter un utilisateur
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login'];
    $email = $_POST['email']; // Récupérer l'email
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

    // Gestion de l'upload de la photo
    $targetDir = "profil/";
    $profileImage = $_FILES['profile']['name'];
    $targetFilePath = $targetDir . basename($profileImage);

    // Déplacer l'image téléchargée
    if (move_uploaded_file($_FILES['profile']['tmp_name'], $targetFilePath)) {
        // Requête SQL pour insérer les données dans la base
        $sql = "INSERT INTO Users (nom, prenom, login, email, password, profile) VALUES ('$nom', '$prenom', '$login', '$email', '$password', '$targetFilePath')";

        // Exécuter la requête
        if ($conn->query($sql) === TRUE) {
            echo "Inscription réussie !";
            // Rediriger vers la page users.php après l'ajout
            header("Location: users.php");
            exit();
        } else {
            echo "Erreur : " . $conn->error;
        }
    } else {
        echo "Erreur lors de l'upload de la photo.";
    }
}
?>

<!-- Formulaire HTML pour ajouter un utilisateur -->
<div class="ma-div">
<form method="POST" enctype="multipart/form-data">
    <label>Nom :</label><br>
    <input type="text" name="nom" required><br>

    <label>Prénom :</label><br>
    <input type="text" name="prenom" required><br>

    <label>Login :</label><br>
    <input type="text" name="login" required><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="password" required><br>

    <label>Photo de profil :</label><br>
    <input type="file" name="profile" accept="image/*" required><br><br>

    <button type="submit" name="submit">Ajouter un utilisateur</button>
    <br>
    <br>
    <br>

<!-- Lien pour revenir à la liste des utilisateurs -->
<a href="users.php">Retour à la liste des utilisateurs</a>
</form>
</div>
</body>
</html>