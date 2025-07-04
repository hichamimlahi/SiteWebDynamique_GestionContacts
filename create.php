<?php
require 'db.php';
require 'auth.php';
verifierConnexion();

$message = '';
$utilisateur_id = $_SESSION['utilisateur_id'];

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $photo = '';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['photo']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $photo = 'contact_' . uniqid() . '.' . $filetype;
            $upload_path = 'uploads/' . $photo;
            
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $upload_path)) {
                $message = '<div class="alert alert-danger">Erreur lors de l\'upload de l\'image.</div>';
                $photo = '';
            }
        } else {
            $message = '<div class="alert alert-danger">Type de fichier non autorisé. Formats acceptés : JPG, PNG, GIF.</div>';
        }
    }

    if (empty($message)) {
        $sql = 'INSERT INTO personnes(nom, prenom, telephone, email, photo, id_utilisateur, D_ajoute) VALUES(:nom, :prenom, :telephone, :email, :photo, :id_utilisateur, CURDATE())';
        $statement = $connection->prepare($sql);
        $params = [
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':telephone' => $telephone,
            ':email' => $email,
            ':photo' => $photo,
            ':id_utilisateur' => $utilisateur_id
        ];
        
        if ($statement->execute($params)) {
            $message = '<div class="alert alert-success">Contact créé avec succès. <a href="index.php">Retour à la liste</a>.</div>';
        } else {
            $message = '<div class="alert alert-danger">Erreur lors de la création du contact.</div>';
        }
    }
}

require 'header.php';
?>

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-user-plus me-2"></i>Créer un nouveau contact</h2>
    </div>
    <div class="card-body">
        <?php if (!empty($message)): ?>
            <?= $message; ?>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" id="nom" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" name="telephone" id="telephone" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo du contact</label>
                <input class="form-control" type="file" name="photo" id="photo">
                <div class="form-text">Formats autorisés : JPG, PNG, GIF.</div>
            </div>
            <div class="mt-4">
                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Enregistrer le contact</button>
                <a href="index.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>
