<?php
$client_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    die("Veuillez vous connecter pour accéder aux paiements.");
}

$sql = "SELECT p.id, p.commande_id, p.montant, p.date_paiement, p.mode_paiement,
               c.statut AS commande_statut
        FROM paiements p
        JOIN commandes c ON p.commande_id = c.id
        WHERE c.client_id = $client_id
        ORDER BY p.date_paiement DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="display-6 mb-0">
                <i class="bi bi-credit-card text-primary"></i> Mes Paiements
            </h2>
            <p class="text-muted mt-2">Liste de tous vos paiements effectués</p>
        </div>
        <a href="index.php?action=listeProduitsClients" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour à la boutique
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Paiement réussi !</strong> Votre paiement a été enregistré avec succès.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="px-4 py-3">ID Paiement</th>
                            <th class="px-4 py-3">ID Commande</th>
                            <th class="px-4 py-3 text-center">Montant Payé</th>
                            <th class="px-4 py-3 text-center">Mode de Paiement</th>
                            <th class="px-4 py-3 text-center">Statut Commande</th>
                            <th class="px-4 py-3 text-center">Date de Paiement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($paiement = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="px-4 py-3"><?= htmlspecialchars($paiement['id']) ?></td>
                                    <td class="px-4 py-3"><?= htmlspecialchars($paiement['commande_id']) ?></td>
                                    <td class="px-4 py-3 text-center fw-bold">
                                        <?= number_format($paiement['montant'], 0, ',', ' ') ?> FCFA
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge bg-info">
                                            <?= htmlspecialchars($paiement['mode_paiement']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge 
                                            <?= $paiement['commande_statut'] == 'en attente' ? 'bg-warning' : 
                                               ($paiement['commande_statut'] == 'validée' ? 'bg-success' : 
                                               ($paiement['commande_statut'] == 'livrée' ? 'bg-primary' : 'bg-secondary')) ?>">
                                            <?= htmlspecialchars($paiement['commande_statut']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?= date('d/m/Y H:i', strtotime($paiement['date_paiement'])) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-credit-card text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-3 mb-0">Aucun paiement trouvé.</p>
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