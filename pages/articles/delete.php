<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "DELETE FROM produits WHERE id = '$product_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?action=listeProduits");
        exit();
    } else {
        $message = "<div class='alert alert-danger text-center'>Erreur lors de la suppression du produit</div>";
    }
} else {
    $message = "<div class='alert alert-danger text-center'>Produit introuvable</div>";
}
?>

<?= isset($message) ? $message : '' ?>
