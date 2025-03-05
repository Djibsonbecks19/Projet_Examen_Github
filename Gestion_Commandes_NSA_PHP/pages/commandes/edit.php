<?php

$id = $_GET['id']; 
$result = mysqli_query($conn, "SELECT * FROM commandes WHERE id=$id");
$commande = mysqli_fetch_assoc($result);  

$clients = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE role='client'");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_POST['client_id']; 
    $produit_id = $_POST['produit_id']; 
    $quantite = $_POST['quantite'];
    $montant_total = $_POST['montant_total']; 
    $statut = $_POST['statut'];

    $sql = "UPDATE commandes SET 
                client_id='$client_id', produit_id='$produit_id', quantite='$quantite', 
                montant_total='$montant_total', statut='$statut' 
            WHERE id=$id";

    mysqli_query($conn, $sql);
    header("Location: index.php?action=listeCommandes"); 
}
?>

<div class="container mt-5">
    <h2 class="text-center">Modifier la Commande</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="client_id" class="form-label">Client:</label>
            <select name="client_id" id="client_id" class="form-select" required>
                <?php while ($client = mysqli_fetch_assoc($clients)) { ?>
                    <option value="<?= $client['id'] ?>" <?= ($client['id'] == $commande['client_id']) ? 'selected' : '' ?>>
                        <?= $client['nom'] . ' ' . $client['prenom'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="montant_total" class="form-label">Montant Total (€):</label>
            <input type="number" step="0.01" name="montant_total" id="montant_total" class="form-control" 
                   value="<?= $commande['montant_total'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut:</label>
            <select name="statut" id="statut" class="form-select" required>
                <option value="En attente" <?= ($commande['statut'] == 'En attente') ? 'selected' : '' ?>>En attente</option>
                <option value="Validée" <?= ($commande['statut'] == 'Validée') ? 'selected' : '' ?>>Validée</option>
                <option value="Expédiée" <?= ($commande['statut'] == 'Expédiée') ? 'selected' : '' ?>>Expédiée</option>
                <option value="Livrée" <?= ($commande['statut'] == 'Livrée') ? 'selected' : '' ?>>Livrée</option>
                <option value="Annulée" <?= ($commande['statut'] == 'Annulée') ? 'selected' : '' ?>>Annulée</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-warning btn-lg">Modifier</button>
        </div>
    </form>
</div>
