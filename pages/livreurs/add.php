<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];

    $query = "INSERT INTO livreurs (nom, prenom, telephone) VALUES ('$nom', '$prenom', '$telephone')";
    mysqli_query($conn, $query);

    header("Location: index.php?action=listeLivreurs");
}
?>

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Ajouter un livreur</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control rounded-3" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control rounded-3" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control rounded-3" required>
                </div>
                <button type="submit" class="btn btn-primary rounded-3">Ajouter</button>
                <a href="?action=listeLivreurs" class="btn btn-secondary rounded-3">Annuler</a>
            </form>
        </div>
    </div>
</div>
