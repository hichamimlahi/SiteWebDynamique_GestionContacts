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

$sql = 'SELECT * FROM personnes WHERE id=:id AND id_utilisateur = :id_utilisateur';
$statement = $connection->prepare($sql);
$statement->execute([':id' => $id, ':id_utilisateur' => $utilisateur_id]);
$personne = $statement->fetch(PDO::FETCH_OBJ);

if (!$personne) {
    header('Location: index.php');
    exit();
}

$message = '';

if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $current_photo = $personne->photo;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['photo']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            if (!empty($current_photo) && file_exists('uploads/' . $current_photo)) {
                unlink('uploads/' . $current_photo);
            }
            $new_photo_name = 'contact_' . uniqid() . '.' . $filetype;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $new_photo_name)) {
                $current_photo = $new_photo_name;
            } else {
                $message = '<div class="alert alert-danger">Erreur lors de l\'upload de la nouvelle image.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Type de fichier non autorisé pour la photo. Formats acceptés : JPG, PNG, GIF.</div>';
        }
    }

    if (empty($message)) {
        $sql = 'UPDATE personnes SET nom=:nom, prenom=:prenom, telephone=:telephone, email=:email, photo=:photo WHERE id=:id AND id_utilisateur = :id_utilisateur';
        $statement = $connection->prepare($sql);
        $params = [
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':telephone' => $telephone,
            ':email' => $email,
            ':photo' => $current_photo,
            ':id' => $id,
            ':id_utilisateur' => $utilisateur_id
        ];
        
        if ($statement->execute($params)) {
            header("Location: index.php");
            exit();
        } else {
            $message = '<div class="alert alert-danger">Erreur lors de la mise à jour du contact.</div>';
        }
    }
}

require 'header.php';
?>

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-edit me-2"></i>Modifier le contact</h2>
    </div>
    <div class="card-body">
        <?php if (!empty($message)): ?>
            <?= $message; ?>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4 text-center">
                    <p class="fw-bold">Photo actuelle</p>
                    <?php if (!empty($personne->photo)): ?>
                        <img src="uploads/<?= htmlspecialchars($personne->photo); ?>" alt="Photo" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <img src="https://placehold.co/150x150/E8E8E8/999999?text=Aucune" alt="Pas de photo" class="img-fluid rounded-circle mb-3">
                    <?php endif; ?>
                    <label for="photo" class="form-label">Changer la photo</label>
                    <input class="form-control form-control-sm" type="file" name="photo" id="photo">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input value="<?= htmlspecialchars($personne->nom); ?>" type="text" name="nom" id="nom" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input value="<?= htmlspecialchars($personne->prenom); ?>" type="text" name="prenom" id="prenom" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" value="<?= htmlspecialchars($personne->email); ?>" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="tel" value="<?= htmlspecialchars($personne->telephone); ?>" name="telephone" id="telephone" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Mettre à jour</button>
                <a href="index.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php require 'footer.php'; ?>
