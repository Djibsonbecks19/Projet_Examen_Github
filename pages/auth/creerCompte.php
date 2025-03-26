<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $role = 1; 
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);  
    }

    if ($_FILES['pp']['error'] === 0) {
        $pp_destination = $upload_dir . uniqid() . '.' . pathinfo($_FILES['pp']['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['pp']['tmp_name'], $pp_destination)) {
            $sql = "INSERT INTO utilisateurs (nom, prenom, telephone, adresse, role, login, password, pp) 
                    VALUES ('$nom', '$prenom', '$telephone', '$adresse', '$role', '$login', '$password', '$pp_destination')";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
                exit();
            } else {
                $error = "Erreur lors de la création du compte";
            }
        } else {
            $error = "Erreur lors de l'upload de la photo de profil";
        }
    } else {
        $error = "Veuillez sélectionner une photo de profil";
    }
}
?>

<div class="container iibs-login-container col-md-6">
    <div class="card iibs-login-card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                <h1>Créer un Compte</h1>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="nom" class="mt-2">Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="mt-2">Prénom</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="telephone" class="mt-2">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="adresse" class="mt-2">Adresse</label>
                    <input type="text" name="adresse" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="login" class="mt-2">Login</label>
                    <input type="text" name="login" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="mt-2">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="pp" class="mt-2">Photo de Profil</label>
                    <input type="file" name="pp" class="form-control" required>
                </div>
                <div class="mt-5">
                    <button type="submit" class="iibs-login-card btn btn-success" name="creerCompte">Créer un Compte</button>
                </div>
            </form>
        </div>
    </div>
</div>