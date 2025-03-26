<?php
$result = mysqli_query($conn, "SELECT * FROM utilisateurs ");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmDelete(url) {
            if (confirm("Voulez-vous vraiment supprimer ce client ?")) {
                window.location.href = url;
            }
        }
    </script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Liste des Clients</h3>
        </div>
        <div class="card-body">
            <a href="index.php?action=addClient" class="btn btn-success mb-3">
                <i class="bi bi-person-plus"></i> Ajouter un Client
            </a>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Rôle</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($client = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?= htmlspecialchars($client['nom']) ?></td>
                                <td><?= htmlspecialchars($client['prenom']) ?></td>
                                <td><?= htmlspecialchars($client['telephone']) ?></td>
                                <td><?= htmlspecialchars($client['adresse']) ?></td>
                                <td><?= htmlspecialchars($client['role']) ?></td>
                                <td>
                                    <?php if($client['pp']) {?>
                                        <img src="<?= $client['pp']?>" width="50" height="50" class="rounded-circle border">
                                    <?php } else { 
                                        echo "Aucune photo";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="index.php?action=viewClient&id=<?= $client['id'] ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                    <a href="index.php?action=editClient&id=<?= $client['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Modifier
                                    </a>
                                    <button onclick="confirmDelete('index.php?action=deleteClient&id=<?= $client['id'] ?>')" class="btn btn-danger btn-sm">
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
</body>
</html>
