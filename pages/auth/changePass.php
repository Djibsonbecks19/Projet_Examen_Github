<?php

require './vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '470c2aecd57bd8';
    $mail->Password = 'a4215e3205aed6'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 2525;

    $mail->setFrom('traodjibril.250@mail.com', 'NSA Commandes');
    $mail->addAddress($_SESSION['login']); 

    $mail->isHTML(true);
    $mail->Subject = 'Test Email';
    $mail->Body = '<p>Vous avez changeé votre mot de passe avec succès</p>';

    $mail->send();
    echo "Email envoyé avec succès !";
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    
    if(empty($login) || empty($old_password) || empty($new_password)){
        $error = "Tous les Champs sont Obligatoires";
    } else {
        $sql = "SELECT * FROM utilisateurs WHERE login = '$login'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row && $old_password == $row['password']) {
                $update_sql = "UPDATE utilisateurs SET password = '$new_password' WHERE login = '$login'";
                if (mysqli_query($conn, $update_sql)) {
                    $success = "Mot de passe mis à jour avec succès";

                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'sandbox.smtp.mailtrap.io';
                        $mail->SMTPAuth = true;
                        $mail->Username = '470c2aecd57bd8';
                        $mail->Password = 'a4215e3205aed6'; // Remplacer avec ton mot de passe
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 2525;

                        $mail->setFrom('traodjibril.250@mail.com', 'Votre Entreprise');
                        $mail->addAddress('traodjibril.250@mail.com');  // Tester l'envoi à une adresse

                        $mail->isHTML(true);
                        $mail->Subject = 'Test Email';
                        $mail->Body = '<p>Ceci est un test</p>';

                        $mail->send();
                        echo "Email envoyé avec succès !";
                    } catch (Exception $e) {
                        echo "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
                    }
                    header("Location: index.php?action=");

                } else {
                    $error = "Erreur lors de la mise à jour du mot de passe";
                }
            } else {
                $error = "Ancien mot de passe incorrect";
            }
        } else {
            $error = "Utilisateur introuvable";
        }
    }
    
    mysqli_close($conn);
}
?>

<div class="container iibs-login-container col-md-6">
    <div class="card iibs-login-card">
        <div class="card-header"></div>
        <div class="card-body">
            <form action="#" method="POST">
                <h1>Changer le mot de passe</h1>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="mt-2">Login</label>
                    <input type="text" name="login" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="mt-2">Ancien mot de passe</label>
                    <input type="password" name="old_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="mt-2">Nouveau mot de passe</label>
                    <input type="password" name="new_password" class="form-control">
                </div>
                <div class="mt-5">
                    <button type="submit" class="iibs-login-card btn btn-success">Changer</button>
                </div>
            </form>
        </div>
    </div>
</div>