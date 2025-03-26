<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if(empty($login) || empty($password)){
        $error = "Tous les Champs sont Obligatoires";
    } else {
        $sql = "SELECT * FROM utilisateurs WHERE login = '$login'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row && $password == $row['password']) {
                    $_SESSION["role"] = $row["role"];
                    $_SESSION["login"] = $login;
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["nom"] = $row["nom"];
                    $_SESSION["prenom"] = $row["prenom"];
                    $_SESSION["pp"] = $row["pp"];

                    if ($_SESSION["role"] == "client") {
                        header("Location: index.php?action=listeProduitsClients");
                        exit();
                    }

                    if ($_SESSION["role"] == "RS") {
                        header("Location: index.php?action=listeProduits");
                        exit();
                    }
                    if ($_SESSION["role"] == "Secretaire") {
                        header("Location: index.php?action=listeCommandes");
                        exit();
                    }
            } else {
                $error = "Login ou Mot de passe incorrect";
            }
        } else {
            $error = "Login ou Mot de passe incorrect";
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>
<div class="container iibs-login-container col-md-6">
    <div class="card iibs-login-card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="#" method="POST">
                <h1>Se connecter</h1>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="" class="mt-2">Login</label>
                    <input type="text" name="login" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="mt-5">Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="iibs-login-card btn btn-success" name="seConnecter">Se Connecter</button>
                </div>
                <div class="mt-3 text-center">
                    <p>Vous n'avez pas de compte? <a href="index.php?action=creerCompte">Créer un compte</a></p>
                </div>
            </form>
        </div>
    </div>
</div>