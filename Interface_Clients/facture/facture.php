<?php
if (!isset($_SESSION['id'])) {
    die("Veuillez vous connecter pour accéder à cette page.");
}

if (!isset($_GET['commande_id'])) {
    die("Aucune commande spécifiée.");
}

$commande_id = mysqli_real_escape_string($conn, $_GET['commande_id']);
$client_id = $_SESSION['id'];

// Get invoice data
$sql = "SELECT c.id, c.date_commande, c.montant_total, c.statut,
               p.date_paiement, p.mode_paiement,
               u.nom AS client_nom, u.prenom AS client_prenom,
               l.adresse_livraison, l.date_livraison,
               livreur.nom AS livreur_nom, livreur.prenom AS livreur_prenom
        FROM commandes c
        JOIN paiements p ON c.id = p.commande_id
        JOIN utilisateurs u ON c.client_id = u.id
        JOIN livraisons l ON c.id = l.commande_id
        JOIN utilisateurs livreur ON l.livreur_id = livreur.id
        WHERE c.id = '$commande_id' AND c.client_id = '$client_id'";

$result = mysqli_query($conn, $sql);
$facture = mysqli_fetch_assoc($result);

if (!$facture) {
    die("Facture introuvable ou accès non autorisé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #<?= $facture['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            color: #555;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>Facture</h2>
                            </td>
                            <td>
                                N° <?= $facture['id'] ?><br>
                                Date: <?= date('d/m/Y', strtotime($facture['date_paiement'])) ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Votre Entreprise</strong><br>
                                123 Rue Principale<br>
                                Ville, Pays<br>
                                Tél: 0123456789
                            </td>
                            <td>
                                <strong>Client</strong><br>
                                <?= $facture['client_prenom'] ?> <?= $facture['client_nom'] ?><br>
                                Livraison: <?= $facture['adresse_livraison'] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Description</td>
                <td>Montant</td>
            </tr>
            
            <tr class="item">
                <td>Commande #<?= $facture['id'] ?></td>
                <td><?= number_format($facture['montant_total'], 0, ',', ' ') ?> FCFA</td>
            </tr>
            
            <tr class="total">
                <td></td>
                <td>Total: <?= number_format($facture['montant_total'], 0, ',', ' ') ?> FCFA</td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Mode de paiement:</strong> <?= $facture['mode_paiement'] ?><br>
                                <strong>Date de paiement:</strong> <?= date('d/m/Y H:i', strtotime($facture['date_paiement'])) ?>
                            </td>
                            <td>
                                <strong>Livreur:</strong> <?= $facture['livreur_prenom'] ?> <?= $facture['livreur_nom'] ?><br>
                                <strong>Date livraison:</strong> <?= date('d/m/Y', strtotime($facture['date_livraison'])) ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="text-center mt-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Imprimer la facture
        </button>
        <a href="index.php?action=listeCommandesClients" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour aux commandes
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>