<?php
$client_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    die("Veuillez vous connecter pour accéder aux livraisons.");
}

$sql = "SELECT l.id, l.commande_id, l.date_livraison, l.adresse_livraison, l.payée,
               p.date_paiement, p.mode_paiement,
               u.nom AS livreur_nom, u.prenom AS livreur_prenom, u.telephone AS livreur_telephone,
               c.montant_total, c.statut AS commande_statut, p.id AS paiement_id
        FROM livraisons l
        JOIN utilisateurs u ON l.livreur_id = u.id AND u.role = 'livreur'
        JOIN commandes c ON l.commande_id = c.id
        LEFT JOIN paiements p ON p.commande_id = c.id
        WHERE c.client_id = $client_id
        ORDER BY l.date_livraison DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="display-6 mb-0">
                <i class="bi bi-truck text-primary"></i> Mes Livraisons
            </h2>
            <p class="text-muted mt-2">Liste de toutes vos livraisons</p>
        </div>
        <a href="index.php?action=listeProduitsClients" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour à la boutique
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="px-4 py-3">ID Livraison</th>
                            <th class="px-4 py-3">ID Commande</th>
                            <th class="px-4 py-3">Livreur</th>
                            <th class="px-4 py-3">Téléphone</th>
                            <th class="px-4 py-3 text-center">Montant</th>
                            <th class="px-4 py-3 text-center">Statut</th>
                            <th class="px-4 py-3 text-center">Date Livraison</th>
                            <th class="px-4 py-3">Adresse</th>
                            <th class="px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($livraison = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="px-4 py-3"><?= htmlspecialchars($livraison['id']) ?></td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($livraison['commande_id']) ?></td>
                                    <td class="px-4 py-3">
                                        <?= htmlspecialchars($livraison['livreur_prenom'] . ' ' . $livraison['livreur_nom']) ?>
                                    </td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($livraison['livreur_telephone']) ?></td>
                                    <td class="px-4 py-3 text-center fw-bold">
                                        <?= number_format($livraison['montant_total'], 0, ',', ' ') ?> FCFA
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge 
                                            <?= $livraison['commande_statut'] == 'en attente' ? 'bg-warning' : 
                                               ($livraison['commande_statut'] == 'validée' ? 'bg-info' : 
                                               ($livraison['commande_statut'] == 'livrée' ? 'bg-success' : 'bg-secondary')) ?>">
                                            <?= htmlspecialchars($livraison['commande_statut']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?= date('d/m/Y H:i', strtotime($livraison['date_livraison'])) ?>
                                    </td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($livraison['adresse_livraison']) ?></td>
                                    <td class="px-4 py-3 text-center">
                                        <?php if ($livraison['commande_statut'] == 'validée' && empty($livraison['paiement_id'])): ?>
                                            <a href="index.php?action=paiementCommande&commande_id=<?= $livraison['commande_id'] ?>" 
                                                class="btn btn-sm btn-success">
                                                <i class="bi bi-credit-card"></i> Payer
                                            </a>
                                            <?php elseif ($livraison['payée'] == 1): ?>
                                                <span class="badge bg-success">
                                                    Payée le <?= date('d/m/Y', strtotime($livraison['date_paiement'])) ?>
                                                    (<?= htmlspecialchars($livraison['mode_paiement']) ?>)
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">En attente</span>
                                            <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-truck text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-3 mb-0">Aucune livraison trouvée.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>