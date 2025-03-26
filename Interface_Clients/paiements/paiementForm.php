    <?php

    if (!isset($_SESSION['id'])) {
        die("Veuillez vous connecter pour effectuer un paiement.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $commande_id = $_POST['commande_id'];
        $montant = $_POST['montant'];
        $mode_paiement = $_POST['mode_paiement'];
        $client_id = $_SESSION['id'];

        $check_sql = "SELECT id FROM commandes 
                    WHERE id = '$commande_id' 
                    AND client_id = '$client_id' 
                    AND statut != 'payée'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) == 0) {
            header("Location: index.php?action=listeCommandesClients&error=Commande+invalide+ou+déjà+payée");
            exit();
        }

        $sql_paiement = "INSERT INTO paiements (commande_id, montant, date_paiement, mode_paiement) 
                        VALUES ('$commande_id', '$montant', NOW(), '$mode_paiement')";
        mysqli_query($conn, $sql_paiement);

        $sql_livraison = "UPDATE livraisons SET payée = '1' WHERE commande_id = '$commande_id'";
        mysqli_query($conn, $sql_livraison);


        $sql_commande = "UPDATE commandes SET statut = 'payée' WHERE id = '$commande_id'";
        mysqli_query($conn, $sql_commande);
        $_SESSION["commande_id"] = $commande_id;
        header("Location: index.php?action=facture&commande_id=$commande_id");
        exit();
    }

    if (!isset($_GET['commande_id'])) {
        die("Aucune commande spécifiée.");
    }

    $commande_id = mysqli_real_escape_string($conn, $_GET['commande_id']);
    $client_id = $_SESSION['id'];

    $sql = "SELECT id, montant_total, statut 
            FROM commandes 
            WHERE id = '$commande_id' AND client_id = '$client_id' AND statut != 'payée'";
    $result = mysqli_query($conn, $sql);
    $commande = mysqli_fetch_assoc($result);


    if (!$commande) {
        die("Commande invalide ou déjà payée.");
    }
    ?>


    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="bi bi-credit-card"></i> Paiement de la Commande #<?= $commande['id'] ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <input type="hidden" name="commande_id" value="<?= $commande['id'] ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Montant à Payer</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" 
                                        value="<?= number_format($commande['montant_total'], 0, ',', ' ') ?> FCFA" 
                                        readonly>
                                    <input type="hidden" name="montant" value="<?= $commande['montant_total'] ?>">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mode de Paiement</label>
                                <select name="mode_paiement" class="form-select" required>
                                    <option value="">Sélectionnez un mode de paiement</option>
                                    <option value="Espèces">Espèces</option>
                                    <option value="Mobile Money">Mobile Money</option>
                                    <option value="Carte Bancaire">Carte Bancaire</option>
                                </select>
                            </div>
        
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle"></i> Confirmer le Paiement
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="index.php?action=listeCommandesClients" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Retour aux Commandes
                    </a>
                </div>
            </div>
        </div>
    </div>
