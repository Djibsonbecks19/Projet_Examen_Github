<?php
$client_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    die("Veuillez vous connecter pour accéder au panier.");
}

$sql = "SELECT * FROM commandes WHERE client_id = $client_id ORDER BY date_commande DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="display-6 mb-0">
                <i class="bi bi-receipt text-primary"></i> Mes Commandes
            </h2>
            <p class="text-muted mt-2">Liste de toutes vos commandes passées</p>
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
                            <th class="px-4 py-3">ID Commande</th>
                            <th class="px-4 py-3">Produit</th>
                            <th class="px-4 py-3 text-center">Quantité</th>
                            <th class="px-4 py-3 text-center">Montant Total</th>
                            <th class="px-4 py-3 text-center">Statut</th>
                            <th class="px-4 py-3 text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($commande = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td class="px-4 py-3"><?= htmlspecialchars($commande['id']) ?></td>
                                    <td class="px-4 py-3">
                                        <?= htmlspecialchars($commande['produit_id']) ?> <!-- Replace with product name if available -->
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?= htmlspecialchars($commande['quantite']) ?>
                                    </td>
                                    <td class="px-4 py-3 text-center fw-bold">
                                        <?= number_format($commande['montant_total'], 0, ',', ' ') ?> FCFA
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge 
                                            <?= $commande['statut'] == 'en attente' ? 'bg-warning' : 
                                               ($commande['statut'] == 'validée' ? 'bg-success' : 
                                               ($commande['statut'] == 'livrée' ? 'bg-primary' : 'bg-secondary')) ?>">
                                            <?= htmlspecialchars($commande['statut']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-3 mb-0">Aucune commande trouvée.</p>
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