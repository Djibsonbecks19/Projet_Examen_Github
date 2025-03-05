<?php

$result = mysqli_query($conn, "SELECT c.*, u.nom, u.prenom, p.libelle AS produit_nom 
                               FROM commandes c
                               JOIN utilisateurs u ON c.client_id = u.id
                               JOIN produits p ON c.produit_id = p.id");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmDelete(url) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette commande ?")) {
                window.location.href = url;
            }
        }
    </script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Liste des Commandes</h3>
        </div>
        <div class="card-body">
            <a href="index.php?action=addCommande" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Ajouter une Commande
            </a>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Produits</th>
                            <th>Montant Total</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($commande = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= htmlspecialchars($commande['nom']) . ' ' . htmlspecialchars($commande['prenom']) ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($commande['date_commande'])) ?></td>
                                <td><?= htmlspecialchars($commande['produit_nom']) ?></td> 
                                <td><?= number_format($commande['montant_total'], 2) ?> FCFA</td> 
                                <td>
                                    <span class="badge badge-<?= getStatusBadgeClass($commande['statut']) ?>">
                                        <?= htmlspecialchars($commande['statut']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?action=viewCommande&id=<?= $commande['id'] ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                    <a href="index.php?action=editCommande&id=<?= $commande['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <button onclick="confirmDelete('index.php?action=deleteCommande&id=<?= $commande['id'] ?>')" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>

<?php
function getStatusBadgeClass($statut) {
    switch ($statut) {
        case 'En attente':
            return 'warning';
        case 'Validée':
            return 'success';
        case 'Expédiée':
            return 'info';
        case 'Livrée':
            return 'primary';
        case 'Annulée':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>
