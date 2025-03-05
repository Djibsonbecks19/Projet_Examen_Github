<?php
$sql = "SELECT * FROM produits";
$result = mysqli_query($conn, $sql);
?>
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Liste des Produits</h3>
        </div>
        <div class="card-body">
            <div class="text-end mb-3">
                <a href="index.php?action=addProduit" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Ajouter un Produit
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Libellé</th>
                            <th>Quantité Stock</th>
                            <th>Prix</th>
                            <th>Quantité Seuil</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= htmlspecialchars($row['libelle']) ?></td>
                                <td><?= $row['quantite_stock'] ?></td>
                                <td><?= number_format($row['prix_unitaire'], 2) ?> FCFA</td>
                                <td><?= $row['quantite_seuil'] ?></td>
                                <td>
                                    <img src="<?= htmlspecialchars($row['image']) ?>" width="50" height="50" class="rounded-circle border">
                                </td>
                                <td>
                                    <a href="index.php?action=editProduit&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Modifier
                                    </a>
                                    <a href="index.php?action=deleteProduit&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
