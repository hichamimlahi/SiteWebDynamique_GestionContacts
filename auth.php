<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function estConnecte() {
    return isset($_SESSION['utilisateur_id']);
}

function verifierConnexion() {
    if (!estConnecte()) {
        header('Location: login.php');
        exit();
    }
}
?>
