<?php
$sql = "SELECT * FROM paiements";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Liste des Paiements</h3>
        </div>
        <div class="card-body">
            <a href="index.php?action=addPaiement" class="btn btn-success mb-3">
                <i class="bi bi-plus-circle"></i> Ajouter un Paiement
            </a>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Client</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['date'])) ?></td>
                                <td><?= number_format($row['montant'], 2, ',', ' ') ?> €</td>
                                <td><?= htmlspecialchars($row['client']) ?></td>
                                <td>
                                    <a href="index.php?action=viewPaiement&id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                    <a href="index.php?action=editPaiement&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <button onclick="confirmDelete('index.php?action=deletePaiement&id=<?= $row['id'] ?>')" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<script>
    function confirmDelete(url) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce paiement ?")) {
            window.location.href = url;
        }
    }
</script>

</body>
</html>
