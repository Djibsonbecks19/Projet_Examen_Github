<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = $_POST['libelle'];
    $quantite_stock = $_POST['quantite_stock'];
    $prix = $_POST['prix_unitaire'];
    $quantite_seuil = $_POST['quantite_seuil'];
    
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);  
    }

    if ($_FILES['image']['error'] === 0) {
        $image_destination = $upload_dir . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_destination)) {
            if (!empty($libelle) && !empty($quantite_stock) && !empty($prix)
                && !empty($quantite_seuil) && !empty($image_destination)) {
                $sql = "INSERT INTO produits (libelle, quantite_stock, prix_unitaire, quantite_seuil, image) 
                        VALUES ('$libelle', '$quantite_stock', '$prix', '$quantite_seuil', '$image_destination')";
                mysqli_query($conn, $sql);
                header("location: index.php?action=listeProduits");
                exit();
            } else {
                $message = "<div class='alert alert-danger text-center'>Tous les champs sont obligatoires</div>";
            }
        } else {
            $message = "<div class='alert alert-danger text-center'>Erreur lors de l'upload de l'image</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>Erreur lors de l'upload de l'image</div>";
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Ajouter un Produit</h3>
        </div> 
        <div class="card-body">
            <?= isset($message) ? $message : '' ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Libellé</label>
                    <input type="text" name="libelle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Quantite Stock</label>
                    <input type="number" step="0.01" name="quantite_stock" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Prix</label>
                    <input type="number" name="prix_unitaire" class="form-control" required>
                </div>  
                <div class="mb-3">
                    <label class="form-label fw-bold">Quantite Seuil</label>
                    <input type="number" step="0.01" name="quantite_seuil" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>