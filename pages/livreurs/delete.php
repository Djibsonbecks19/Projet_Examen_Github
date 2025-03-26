<?php

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM livreurs WHERE id=$id");

header("Location: index.php?action=listeLivreurs");
?>
