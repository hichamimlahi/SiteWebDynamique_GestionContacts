<?php
require_once 'auth.php';

?>
<!doctype html>
<html lang="fr">
<head>
    <title>Carnet de Contacts Professionnel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" xintegrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --bs-primary-rgb: 40, 167, 69;
            --bs-secondary-rgb: 133, 135, 150;
            --background-color: #f8f9fc;
            --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            --font-family: sans-serif;
        }

        body {
            background-color: var(--background-color);
            font-family: var(--font-family);
            color: #5a5c69;
        }

        .navbar {
            box-shadow: var(--card-shadow);
        }

        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: 0.75rem;
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

        .table {
            vertical-align: middle;
        }
        
        .table thead {
             background-color: #f1f1f5;
        }

        .table th {
            font-weight: 600;
        }

        .img-profile {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border: 3px solid #e3e6f0;
        }

        .btn-action {
            width: 40px;
            height: 40px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            margin: 0 5px;
        }
        
        .form-label {
            font-weight: 500;
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
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php">
            <i class="fas fa-book-open me-2"></i>
            Mon Carnet
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (estConnecte()): ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php"><i class="fas fa-home me-1"></i>Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create.php"><i class="fas fa-plus-circle me-1"></i>Créer un contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Déconnexion (<?= htmlspecialchars($_SESSION['nom_utilisateur']) ?>)</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt me-1"></i>Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><i class="fas fa-user-plus me-1"></i>Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container flex-grow-1">
