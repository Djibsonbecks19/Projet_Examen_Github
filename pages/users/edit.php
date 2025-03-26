<?php
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM utilisateurs WHERE id=$id");
$client = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    $sql = "UPDATE utilisateurs SET 
            nom='$nom', prenom='$prenom', telephone='$telephone', adresse='$adresse' 
            WHERE id=$id";

    mysqli_query($conn, $sql);
    header("Location: index.php?action=listeClients");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-white text-center">
                    <h4 class="mb-0">Modifier le Client</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nom:</label>
                            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($client['nom']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prénom:</label>
                            <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($client['prenom']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Téléphone:</label>
                            <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($client['telephone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse:</label>
                            <input type="text" name="adresse" class="form-control" value="<?= htmlspecialchars($client['adresse']) ?>" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3 mb-5">
                <a href="index.php?action=listeClients" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
