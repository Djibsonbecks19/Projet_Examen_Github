<?php
    require_once "shared/database.php";
?>
<!doctype html>
<html lang="en">
    <head>
    <title>Gestion des Commandes</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="pages/css/styles.css">
    </head>

    <body>

    <?php


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    require_once "shared/navbar.php";

    // Clients
    if ($action == 'listeClients') {
        require_once "./pages/clients/liste.php";
    } elseif ($action == 'addClient') {
        require_once "./pages/clients/add.php";
    } elseif ($action == 'editClient') {
        require_once "./pages/clients/edit.php";
    } elseif ($action == 'viewClient') {
        require_once "./pages/clients/view.php";
    } elseif ($action == 'deleteClient') {
        require_once "./pages/clients/delete.php";
    }

    // Commandes
    elseif ($action == 'listeCommandes') {
        require_once "./pages/commandes/liste.php";
    } elseif ($action == 'addCommande') {
        require_once "./pages/commandes/add.php";
    } elseif ($action == 'editCommande') {
        require_once "./pages/commandes/edit.php";
    } elseif ($action == 'viewCommande') {
        require_once "./pages/commandes/view.php";
    } elseif ($action == 'deleteCommande') {
        require_once "./pages/commandes/delete.php";
    }

    // Produits
    elseif ($action == 'listeProduits') {
        require_once "./pages/articles/liste.php";
    } elseif ($action == 'addProduit') {
        require_once "./pages/articles/add.php";
    } elseif ($action == 'editProduit') {
        require_once "./pages/articles/edit.php";
    } elseif ($action == 'deleteProduit') {
        require_once "./pages/articles/delete.php";
    }

    // Livreurs
    elseif ($action == 'listeLivreurs') {
        require_once "./pages/livreurs/liste.php";
    } elseif ($action == 'addLivreur') {
        require_once "./pages/livreurs/add.php";
    } elseif ($action == 'editLivreur') {
        require_once "./pages/livreurs/edit.php";
    } elseif ($action == 'deleteLivreur') {
        require_once "./pages/livreurs/delete.php";
    }

    // Livraisons
    elseif ($action == 'listeLivraisons') {
        require_once "./pages/livraisons/liste.php";
    } elseif ($action == 'planifierLivraison') {
        require_once "./pages/livraisons/planifier.php";
    }

    // Paiements
    elseif ($action == 'listePaiements') {
        require_once "./pages/paiements/liste.php";
    } elseif ($action == 'historiquePaiements') {
        require_once "./pages/paiements/historique.php";
    }

    if($action == 'disconnect'){
        session_destroy();
        header("Location: index.php");
    }
} else {
    // If no 'action' parameter is set in the URL, load the login page
    require_once "pages/auth/login.php";
}
?>

    


        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
