<?php

// Récupérer tous les livreurs
$result = mysqli_query($conn, "SELECT * FROM livreurs");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Livreurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Liste des Livreurs</h3>
        </div>
        <div class="card-body">
            <a href="?action=addLivreur" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Ajouter un livreur
            </a>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($livreur = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($livreur['id']) ?></td>
                                <td><?= htmlspecialchars($livreur['nom']) ?></td>
                                <td><?= htmlspecialchars($livreur['prenom']) ?></td>
                                <td><?= htmlspecialchars($livreur['telephone']) ?></td>
                                <td>
                                    <a href="?action=editLivreur&&id=<?= $livreur['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <a href="?action=deleteLivreur&&id=<?= $livreur['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce livreur ?')">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    function confirmDelete(url) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce livreur ?")) {
            window.location.href = url;
        }
    }
</script>

</body>
</html>
