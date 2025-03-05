<?php

$clients = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE role='client'");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client_id = $_POST['client_id']; 
    $produit_id = $_POST['produit_id']; 
    $quantite = $_POST['quantite']; 
    $statut = $_POST['statut'];
    $date_commande = date('Y-m-d H:i:s'); 

    // Fetch the selected product details to get the prix_unitaire
    $produit_result = mysqli_query($conn, "SELECT * FROM produits WHERE id = '$produit_id'");
    $produit = mysqli_fetch_assoc($produit_result);
    
    $montant_total = $quantite * $produit['prix_unitaire'];

    $sql = "INSERT INTO commandes (client_id, produit_id, quantite, date_commande, montant_total, statut)
            VALUES ('$client_id', '$produit_id', '$quantite', '$date_commande', '$montant_total', '$statut')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?action=listeCommandes");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Ajouter une Commande</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="client_id" class="form-label">Client:</label>
                    <select name="client_id" id="client_id" class="form-select" required>
                        <option value="" disabled selected>Choisir un client</option>
                        <?php
                        // Displaying clients
                        $clients = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE role='client'");
                        while ($client = mysqli_fetch_assoc($clients)) {
                            echo "<option value='{$client['id']}'>{$client['nom']} {$client['prenom']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="produit_id" class="form-label">Produit:</label>
                    <select name="produit_id" id="produit_id" class="form-select" required>
                        <option value="" disabled selected>Choisir un produit</option>
                        <?php
                        // Displaying products
                        $produits = mysqli_query($conn, "SELECT * FROM produits");
                        while ($produit = mysqli_fetch_assoc($produits)) {
                            echo "<option value='{$produit['id']}'>{$produit['libelle']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité:</label>
                    <input type="number" name="quantite" id="quantite" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="statut" class="form-label">Statut:</label>
                    <select name="statut" id="statut" class="form-select" required>
                        <option value="En attente">En attente</option>
                        <option value="Validée">Validée</option>
                        <option value="Expédiée">Expédiée</option>
                        <option value="Livrée">Livrée</option>
                        <option value="Annulée">Annulée</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Ajouter la Commande</button>
                </div>
            </form>
        </div>
    </div>
</div>
