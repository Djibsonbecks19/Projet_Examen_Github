<?php
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['id'])) {
    die("Veuillez vous connecter pour accéder à cette page.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commande_id = mysqli_real_escape_string($conn, $_POST['commande_id']);
    $livreur_id = mysqli_real_escape_string($conn, $_POST['livreur_id']);
    $adresse_livraison = mysqli_real_escape_string($conn, $_POST['adresse_livraison']);

    $check_commande = "SELECT id FROM commandes 
                      WHERE id = '$commande_id' 
                      AND statut = 'validée'";
    $result = mysqli_query($conn, $check_commande);
    
    if (mysqli_num_rows($result) == 0) {
        die("Commande invalide ou non validée.");
    }

    $check_livraison = "SELECT id FROM livraisons WHERE commande_id = '$commande_id'";
    $result = mysqli_query($conn, $check_livraison);
    
    if (mysqli_num_rows($result) > 0) {
        die("Une livraison existe déjà pour cette commande.");
    }

    $check_livreur = "SELECT id FROM utilisateurs WHERE id = '$livreur_id' AND role = 'livreur'";
    $result = mysqli_query($conn, $check_livreur);
    
    if (mysqli_num_rows($result) == 0) {
        die("Livreur sélectionné invalide.");
    }

    $client_sql = "SELECT u.login, u.prenom, u.nom 
                  FROM commandes c
                  JOIN utilisateurs u ON c.client_id = u.id
                  WHERE c.id = '$commande_id'";
    $client_result = mysqli_query($conn, $client_sql);
    $client = mysqli_fetch_assoc($client_result);

    $sql = "INSERT INTO livraisons (commande_id, livreur_id, adresse_livraison, date_livraison)
           VALUES ('$commande_id', '$livreur_id', '$adresse_livraison', NOW())";
    
    if (mysqli_query($conn, $sql)) {
        $update_commande = "UPDATE commandes SET statut = 'validée' WHERE id = '$commande_id'";
        mysqli_query($conn, $update_commande);
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '470c2aecd57bd8';
            $mail->Password = 'a4215e3205aed6';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 2525;

            $mail->setFrom('traodjibril.250@mail.com', 'NSA Commandes');
            $mail->addAddress($client['login']); 
            
            $livreur_sql = "SELECT prenom, nom, telephone FROM utilisateurs WHERE id = '$livreur_id'";
            $livreur_result = mysqli_query($conn, $livreur_sql);
            $livreur = mysqli_fetch_assoc($livreur_result);

            $mail->isHTML(true);
            $mail->Subject = 'Votre commande a ete expediee';
            $mail->Body = '
                <h3>Bonjour ' . htmlspecialchars($client['prenom']) . ',</h3>
                <p>Votre commande #' . htmlspecialchars($commande_id) . ' a ete expediee.</p>
                <p><strong>Détails de livraison :</strong></p>
                <ul>
                    <li>Livreur : ' . htmlspecialchars($livreur['prenom']) . ' ' . htmlspecialchars($livreur['nom']) . '</li>
                    <li>Telephone livreur : ' . htmlspecialchars($livreur['telephone']) . '</li>
                    <li>Adresse de livraison : ' . htmlspecialchars($adresse_livraison) . '</li>
                </ul>
                <p>Merci pour votre confiance !</p>
                <p>L\'équipe NSA Commandes</p>
            ';

            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur d'envoi d'email: " . $e->getMessage());
        }
        
        header("Location: index.php?action=listeLivraisons&success=1");
        exit();
    } else {
        die("Erreur lors de la création de la livraison: " . mysqli_error($conn));
    }
}

$commandes_sql = "SELECT c.id, c.date_commande, c.montant_total, 
                 u.nom AS client_nom, u.prenom AS client_prenom
                 FROM commandes c
                 JOIN utilisateurs u ON c.client_id = u.id
                 WHERE c.statut = 'validée'
                 AND NOT EXISTS (SELECT 1 FROM livraisons l WHERE l.commande_id = c.id)
                 ORDER BY c.date_commande DESC";
$commandes_result = mysqli_query($conn, $commandes_sql);

$livreurs_sql = "SELECT id, nom, prenom, telephone FROM utilisateurs WHERE role = 'livreur'";
$livreurs_result = mysqli_query($conn, $livreurs_sql);
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-truck"></i> Planifier une Nouvelle Livraison
                    </h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Commande à Livrer</label>
                            <select name="commande_id" class="form-select" required>
                                <option value="">Sélectionnez une commande</option>
                                <?php while ($commande = mysqli_fetch_assoc($commandes_result)): ?>
                                    <option value="<?= htmlspecialchars($commande['id']) ?>">
                                        Commande #<?= htmlspecialchars($commande['id']) ?> - 
                                        <?= htmlspecialchars($commande['client_prenom']) ?> <?= htmlspecialchars($commande['client_nom']) ?> - 
                                        <?= number_format($commande['montant_total'], 0, ',', ' ') ?> FCFA - 
                                        <?= date('d/m/Y', strtotime($commande['date_commande'])) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Livreur</label>
                            <select name="livreur_id" class="form-select" required>
                                <option value="">Sélectionnez un livreur</option>
                                <?php while ($livreur = mysqli_fetch_assoc($livreurs_result)): ?>
                                    <option value="<?= htmlspecialchars($livreur['id']) ?>">
                                        <?= htmlspecialchars($livreur['prenom']) ?> <?= htmlspecialchars($livreur['nom']) ?> - 
                                        <?= htmlspecialchars($livreur['telephone']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adresse de Livraison</label>
                            <textarea name="adresse_livraison" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php?action=listeLivraisons" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Enregistrer la Livraison
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>