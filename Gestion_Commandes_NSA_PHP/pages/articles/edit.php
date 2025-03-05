<?php
$id = $_GET['id'];
$sql = "SELECT * FROM produits WHERE id = $id";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = $_POST['libelle'];
    $quantite_stock = $_POST['quantite_stock'];
    $prix = $_POST['prix'];
    $quantite_seuil = $_POST['quantite_seuil'];
    $image = $_POST['image'];

    if (!empty($libelle) && !empty($quantite_stock) && !empty($prix) 
        && !empty($quantite_seuil) && !empty($image)) {
        $sql = "UPDATE produits SET libelle='$libelle',  quantite_stock='$quantite_stock', prix_unitaire='$prix',quantite_seuil='$quantite_seuil', image='$image' WHERE id=$id";
        mysqli_query($conn, $sql);
        header("location: index.php?action=listeProduits");
    } else {
        $message = "<div class='alert alert-danger text-center'>Tous les champs sont obligatoires</div>";
    }
}
?>

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-warning text-white text-center">
            <h3 class="mb-0">Modifier un Produit</h3>
        </div>
        <div class="card-body">
            <?= isset($message) ? $message : '' ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Libellé</label>
                    <input type="text" name="libelle" class="form-control" value="<?= $row['libelle'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Quantité Stock</label>
                    <input type="number" name="quantite_stock" class="form-control" value="<?= $row['quantite_stock'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Prix</label>
                    <input type="number" step="0.01" name="prix" class="form-control" value="<?= $row['prix_unitaire'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Quantité Seuil</label>
                    <input type="number" name="quantite_seuil" class="form-control" value="<?= $row['quantite_seuil'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Image (URL)</label>
                    <input type="text" name="image" class="form-control" value="<?= $row['image'] ?>">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Modifier</button>
                    <a href="index.php?action=listeProduit" class="btn btn-secondary px-4">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
