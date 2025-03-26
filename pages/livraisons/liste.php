<?php
require_once "shared/database.php";

if (!isset($_SESSION['id'])) {
    die("Veuillez vous connecter pour accéder à cette page.");
}

$sql = "SELECT l.id, l.date_livraison, l.adresse_livraison,
               c.id AS commande_id, c.montant_total, c.statut AS commande_statut,
               u.nom AS client_nom, u.prenom AS client_prenom,
               livreur.nom AS livreur_nom, livreur.prenom AS livreur_prenom, livreur.telephone AS livreur_telephone
        FROM livraisons l
        JOIN commandes c ON l.commande_id = c.id
        JOIN utilisateurs u ON c.client_id = u.id
        JOIN utilisateurs livreur ON l.livreur_id = livreur.id AND livreur.role = 'livreur'
        ORDER BY l.date_livraison DESC";
$result = mysqli_query($conn, $sql);
?>


<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Liste des Livraisons</h3>
                    <a href="index.php?action=addLivraison" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Planifier une Livraison
                    </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Livraison</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Commande</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Livreur</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($row['date_livraison'])) ?></td>
                                    <td><?= htmlspecialchars($row['client_prenom'] . ' ' . $row['client_nom']) ?></td>
                                    <td>#<?= htmlspecialchars($row['commande_id']) ?></td>
                                    <td><?= number_format($row['montant_total'], 0, ',', ' ') ?> FCFA</td>
                                    <td>
                                        <span class="badge 
                                            <?= $row['commande_statut'] == 'en attente' ? 'bg-warning' : 
                                               ($row['commande_statut'] == 'validée' ? 'bg-info' : 
                                               ($row['commande_statut'] == 'livrée' ? 'bg-success' : 'bg-secondary')) ?>">
                                            <?= htmlspecialchars($row['commande_statut']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row['livreur_prenom'] . ' ' . $row['livreur_nom']) ?><br>
                                        <small><?= htmlspecialchars($row['livreur_telephone']) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($row['adresse_livraison']) ?></td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="index.php?action=viewLivraison&id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                            <?php if ($_SESSION['role'] !== 'client'): ?>
                                                <a href="index.php?action=editLivraison&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i> Modifier
                                                </a>
                                                <button onclick="confirmDelete('index.php?action=deleteLivraison&id=<?= $row['id'] ?>')" 
                                                        class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-truck text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-2">Aucune livraison trouvée</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(url) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cette livraison ?")) {
            window.location.href = url;
        }
    }
</script>
