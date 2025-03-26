<?php
$id_client = $_SESSION["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produit = $_POST['produit_id'];
    $libelle = mysqli_real_escape_string($conn, $_POST['libelle']);
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $total = $prix * $quantite;
    $image = $_POST['image'];

    $query = "INSERT INTO panier (product_id, libelle_produit, prix_unitaire, quantité, id_client, total, image)
              VALUES ('$id_produit', '$libelle', '$prix', '$quantite', '$id_client', '$total','$image')";
    
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success mt-5'>Produit ajouté au panier avec succès</div>";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}



$sql = "SELECT * FROM produits";
$result = mysqli_query($conn, $sql);
?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="display-6 mb-0">
                <i class="bi bi-shop text-primary"></i> Notre Boutique
            </h2>
            <p class="text-muted mt-2">Découvrez nos produits de qualité</p>
        </div>
    </div>

    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                    <div class="position-relative">
                        <img src="<?= htmlspecialchars($row['image']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($row['libelle']) ?>" 
                             style="height: 250px; object-fit: cover;">
                        <?php if ($row['quantite_stock'] <= 0) { ?>
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-danger">Rupture de stock</span>
                            </div>
                        <?php } elseif ($row['quantite_stock'] <= 5) { ?>
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-warning">Stock limité</span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-3"><?= htmlspecialchars($row['libelle']) ?></h5>
                        <div class="mb-3">
                            <div class="fs-4 fw-bold text-primary mb-2">
                                <?= number_format($row['prix_unitaire'], 0, ',', ' ') ?> FCFA
                            </div>
                        </div>

                        <form action="" method="POST" class="mt-auto">
                            <input type="hidden" name="produit_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="libelle" value="<?= htmlspecialchars($row['libelle']) ?>">
                            <input type="hidden" name="prix" value="<?= $row['prix_unitaire'] ?>">
                            <input type="hidden" name="image" value="<?= $row['image'] ?>">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="input-group input-group-sm" style="width: 100px;">
                                    <span class="input-group-text">
                                        <i class="bi bi-123"></i>
                                    </span>
                                    <input type="number" name="quantite" class="form-control quantity-input" min="1" max="<?= $row['quantite_stock'] ?>" value="1" <?= $row['quantite_stock'] <= 0 ? 'disabled' : '' ?>>
                                </div>
                                <button type="submit" class="btn btn-primary flex-grow-1" <?= $row['quantite_stock'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="bi bi-cart-plus"></i> Ajouter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
mysqli_close($conn);
?>