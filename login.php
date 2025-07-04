<?php
require 'db.php';
require 'auth.php';

if (estConnecte()) {
    header('Location: index.php');
    exit();
}

$message = '';

if (isset($_POST['submit'])) {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_pass = $_POST['mot_de_pass'];

    $sql = 'SELECT id, nom_utilisateur, mot_de_pass FROM utilisateurs WHERE nom_utilisateur = :nom_utilisateur';
    $statement = $connection->prepare($sql);
    $statement->execute([':nom_utilisateur' => $nom_utilisateur]);
    $utilisateur = $statement->fetch(PDO::FETCH_OBJ);

    if ($utilisateur && password_verify($mot_de_pass, $utilisateur->mot_de_pass)) {
        $_SESSION['utilisateur_id'] = $utilisateur->id;
        $_SESSION['nom_utilisateur'] = $utilisateur->nom_utilisateur;
        header('Location: index.php');
        exit();
    } else {
        $message = '<div class="alert alert-danger">Nom d\'utilisateur ou mot de passe incorrect.</div>';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <title>Connexion - Carnet de Contacts</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --bs-primary-rgb: 40, 167, 69;
            --background-color: #f8f9fc;
            --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        body {
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 0.75rem;
            width: 100%;
            max-width: 400px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        h2 {
            color: rgb(var(--bs-primary-rgb));
            font-weight: 600;
        }
        .form-control:focus {
            border-color: rgba(var(--bs-primary-rgb), 0.5);
            box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
        }
        .btn-primary {
            background-color: rgb(var(--bs-primary-rgb));
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out;
        }
        .btn-primary:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.9);
        }
    </style>
</head>
<body>
    <div class="card p-4">
        <div class="card-header text-center pb-3">
            <h2><i class="fas fa-sign-in-alt me-2"></i>Connexion</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($message)): ?>
                <?= $message; ?>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label for="nom_utilisateur" class="form-label">Nom d'utilisateur</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="nom_utilisateur" id="nom_utilisateur" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="mot_de_pass" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="mot_de_pass" id="mot_de_pass" class="form-control" required>
                    </div>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt me-2"></i>Se connecter</button>
                </div>
                 <div class="mt-3 text-center">
                    <p class="mb-0">Vous n'avez pas de compte ? <a href="register.php">S'inscrire ici</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
