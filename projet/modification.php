<?php 
session_start();
require 'db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis l'URL
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($user_id) {
    // Requête pour récupérer les informations de l'utilisateur depuis la base de données
    $sql = "SELECT * FROM Users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Données de l'utilisateur à modifier
    } else {
        echo "Utilisateur non trouvé.";
        exit();
    }
} else {
    echo "Aucun utilisateur sélectionné.";
    exit();
}

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Si un mot de passe est défini, on le hache avant de l'enregistrer
    if ($password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE Users SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $nom, $prenom, $email, $hashed_password, $user_id);
    } else {
        $sql = "UPDATE Users SET nom = ?, prenom = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nom, $prenom, $email, $user_id);
    }

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Utilisateur modifié avec succès.";
    } else {
        echo "Erreur lors de la modification de l'utilisateur.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2 class="ma">Modification de l'utilisateur</h2>

    <form class="maa" action="modification.php?id=<?php echo $user['id']; ?>" method="POST">
        <!-- Champ caché pour l'ID de l'utilisateur -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

        <label>Nom:</label>
        <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required><br>

        <label>Prénom:</label>
        <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required><br>

        <label>Email: </label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <label>Mot de passe:</label>
        <input type="password" name="password"><br>

        <input type="submit" value="Modifier">
    </form>
<div class="MA">
    <br><a href="users.php">Retour à la liste des utilisateurs</a>
</div>
</body>
</html>
