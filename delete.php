<?php
require 'db.php';
require 'auth.php';
verifierConnexion();

$id = $_GET['id'] ?? null;
$utilisateur_id = $_SESSION['utilisateur_id'];

if ($id === null) {
    header('Location: index.php');
    exit();
}

$sql_select = 'SELECT photo FROM personnes WHERE id=:id AND id_utilisateur = :id_utilisateur';
$statement_select = $connection->prepare($sql_select);
$statement_select->execute([':id' => $id, ':id_utilisateur' => $utilisateur_id]);
$personne = $statement_select->fetch(PDO::FETCH_OBJ);

if ($personne) {
    $sql_delete = 'DELETE FROM personnes WHERE id=:id AND id_utilisateur = :id_utilisateur';
    $statement_delete = $connection->prepare($sql_delete);
    if ($statement_delete->execute([':id' => $id, ':id_utilisateur' => $utilisateur_id])) {
        if (!empty($personne->photo) && file_exists('uploads/' . $personne->photo)) {
            unlink('uploads/' . $personne->photo);
        }
        header("Location: index.php");
        exit();
    }
}
header("Location: index.php");
exit();
?>
