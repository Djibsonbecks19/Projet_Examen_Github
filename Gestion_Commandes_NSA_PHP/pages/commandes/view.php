<?php

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM livreurs WHERE id=$id");
$livreur = mysqli_fetch_assoc($result);

?>

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Détails du Livreur</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($livreur['nom']) ?></li>
                <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($livreur['prenom']) ?></li>
                <li class="list-group-item"><strong>Téléphone :</strong> <?= htmlspecialchars($livreur['telephone']) ?></li>
            </ul>
        </div>
        <div class="card-footer text-center">
            <a href="index.php?action=listeLivreurs" class="btn btn-danger px-4">Retour</a>
        </div>
    </div>
</div>
