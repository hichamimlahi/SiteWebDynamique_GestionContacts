<?php
require 'db.php';
require 'auth.php';
verifierConnexion();

$utilisateur_id = $_SESSION['utilisateur_id'];

$sql = 'SELECT * FROM personnes WHERE id_utilisateur = :id_utilisateur ORDER BY nom, prenom';
$statement = $connection->prepare($sql);
$statement->execute([':id_utilisateur' => $utilisateur_id]);
$personnes = $statement->fetchAll(PDO::FETCH_OBJ);

require 'header.php';
?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-users me-2"></i>Tous vos contacts</h2>
        <a href="create.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Ajouter</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Nom & Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($personnes)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <p class="text-muted">Aucun contact trouvé.</p>
                                <a href="create.php" class="btn btn-primary">Créer votre premier contact</a>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($personnes as $personne): ?>
                        <tr>
                            <td>
                                <?php if (!empty($personne->photo)): ?>
                                    <img src="uploads/<?= htmlspecialchars($personne->photo); ?>" alt="Photo de <?= htmlspecialchars($personne->nom); ?>" class="rounded-circle img-profile">
                                <?php else: ?>
                                    <img src="https://placehold.co/75x75/E8E8E8/999999?text=<?= htmlspecialchars(strtoupper(substr($personne->nom, 0, 1))) ?>" alt="Pas de photo" class="rounded-circle img-profile">
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($personne->nom) ?></div>
                                <div class="text-muted"><?= htmlspecialchars($personne->prenom) ?></div>
                            </td>
                            <td><a href="mailto:<?= htmlspecialchars($personne->email) ?>"><?= htmlspecialchars($personne->email) ?></a></td>
                            <td><?= htmlspecialchars($personne->telephone) ?></td>
                            <td class="text-center">
                                <a href="edit.php?id=<?= htmlspecialchars($personne->id) ?>" class="btn btn-outline-primary btn-action" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contact?')" href="delete.php?id=<?= htmlspecialchars($personne->id) ?>" class='btn btn-outline-danger btn-action' title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'footer.php'; ?>
