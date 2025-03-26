<?php

$client_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    die("Veuillez vous connecter pour accéder au panier.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commander'])) {
    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'];
    $total = $_POST['montant_total'];

    $product_check_sql = "SELECT * FROM produits WHERE id = '$produit_id'";
    $product_check_result = mysqli_query($conn, $product_check_sql);
    $product = mysqli_fetch_assoc($product_check_result);

    // Determine status based on quantity
    $statut = ($quantite > $product['quantite_stock']) ? 'en attente' : 'validée';

    $sql = "INSERT INTO commandes (client_id, produit_id, quantite, montant_total, statut) 
            VALUES ('$client_id', '$produit_id', '$quantite', '$total', '$statut')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?action=listeCommandesClients");
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
}

if (isset($_GET['remove'])) {
    $panier_id = $_GET['remove'];
    $delete_sql = "DELETE FROM panier WHERE id = $panier_id AND id_client = $client_id";
    mysqli_query($conn, $delete_sql);
}

if (isset($_GET['clear'])) {
    $clear_sql = "DELETE FROM panier WHERE id_client = $client_id";
    mysqli_query($conn, $clear_sql);
}

$sql = "SELECT * FROM panier WHERE id_client = $client_id";
$result = mysqli_query($conn, $sql);

$total_sql = "SELECT SUM(total) as total_panier FROM panier WHERE id_client = $client_id";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_panier = $total_row['total_panier'] ?? 0;
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="display-6 mb-0">
                <i class="bi bi-cart3 text-primary"></i> Mon Panier
            </h2>
            <p class="text-muted mt-2">Gérez vos articles sélectionnés</p>
        </div>
        <a href="index.php?action=listeProduitsClients" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Continuer mes achats
        </a>
    </div>

    <div class="row g-4">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($item = mysqli_fetch_assoc($result)): ?>
                <?php 
                // Fetch product details
                $product_sql = "SELECT * FROM produits WHERE id = '{$item['product_id']}'";
                $product_result = mysqli_query($conn, $product_sql);
                $product = mysqli_fetch_assoc($product_result);
                ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="position-relative">
                        <img src="<?= htmlspecialchars($item['image']) ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($item['libelle_produit']) ?>" 
                                 style="height: 250px; object-fit: cover;"
                            >
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-3"><?= htmlspecialchars($item['libelle_produit']) ?></h5>
                            <div class="fs-4 fw-bold text-primary mb-2">
                                <?= number_format($item['prix_unitaire'], 0, ',', ' ') ?> FCFA
                            </div> 
                            <form method="POST" action="" class="mt-auto">
                                <input type="hidden" name="produit_id" value="<?= $item['product_id'] ?>">
                                <input class="form-control mb-3" name="quantite" value="<?= $item['quantité'] ?>" readonly>
                                <input type="hidden" name="montant_total" value="<?= $item['total'] ?>">
                                <?php if ($item['quantité'] > $product['quantite_stock']): ?>
                                    <div class="alert alert-warning">
                                        Quantité demandée supérieure au stock disponible
                                    </div>
                                <?php endif; ?>
                                <button type="submit" name="commander" class="btn btn-primary" 
                                        <?= ($item['quantité'] > $product['quantite_stock']) ? 'disabled' : '' ?>>
                                    <i class="bi bi-credit-card"></i> Commander
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Votre panier est vide.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Total du Panier</h5>
                        <p class="text-muted mb-0">Total de vos articles</p>
                    </div>
                    <div class="text-end">
                        <h3 class="text-primary mb-0">
                            <?= number_format($total_panier, 0, ',', ' ') ?> FCFA
                        </h3>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="?action=viewPanier&clear=1" 
                       class="btn btn-outline-danger"
                       onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">
                        <i class="bi bi-trash"></i> Vider le panier
                    </a>
                    <a href="?action=checkout" class="btn btn-primary">
                        <i class="bi bi-credit-card"></i> Procéder au paiement
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>