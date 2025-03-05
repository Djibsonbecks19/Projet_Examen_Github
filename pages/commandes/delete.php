<?php

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM commandes WHERE id=$id");

header("Location: index.php?action=listeCommandes");
?>
