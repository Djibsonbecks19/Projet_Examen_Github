<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <!-- Brand/Profile Section -->
    <div class="profile-dropdown d-flex align-items-center me-2">
      <button class="profile-trigger">
        <div class="profile-avatar">
          <?php if (isset($_SESSION['pp']) && !empty($_SESSION['pp'])) { ?>
            <img src="<?= $_SESSION['pp'] ?>" width="40" height="40" alt="Profile Picture" class="profile-picture rounded-circle border">
          <?php }else{ ?>
            <?= isset($_SESSION['prenom']) ? strtoupper(substr($_SESSION['prenom'], 0, 1)) : 'U'; ?>
          <?php } ?>
        </div>
        <span class="profile-name text-light"><?= isset($_SESSION['prenom']) ? htmlspecialchars($_SESSION['prenom']) : 'User'; ?></span>
      </button>
    </div>
    
    <!-- Hamburger Menu for Mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Navigation Content (Collapsible) -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Navigation Links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (isset($_SESSION["role"])): ?>
          <?php if ($_SESSION["role"] == 'RS'): ?>
            <!-- RS (Responsable de Secteur) sees only Commandes and Livraisons -->
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeCommandesClients">
                <i class="bi bi-clipboard-check me-1"></i> Commandes
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeLivraisons">
                <i class="bi bi-truck me-1"></i> Livraisons
              </a>
            </li>
            
          <?php elseif ($_SESSION["role"] == 'secretaire'): ?>
            <!-- Secretaire sees only Commandes -->
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeCommandesClients">
                <i class="bi bi-clipboard-check me-1"></i> Commandes
              </a>
            </li>
            
          <?php elseif ($_SESSION["role"] == 'client'): ?>
            <!-- Clients see Boutique, Commandes, Livraisons, and Paiements -->
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeProduitsClients">
                <i class="bi bi-shop me-1"></i> Boutique
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeCommandesClients">
                <i class="bi bi-clipboard-check me-1"></i> Commandes
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeLivraisonsClients">
                <i class="bi bi-truck me-1"></i> Livraisons
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listePaiementsClients">
                <i class="bi bi-credit-card me-1"></i> Paiements
              </a>
            </li>
            
          <?php else: ?>
            <!-- Admin or other roles see all appropriate menu items -->
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeClients">
                <i class="bi bi-people me-1"></i> Clients
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeProduits">
                <i class="bi bi-box me-1"></i> Produits
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeCommandesClients">
                <i class="bi bi-clipboard-check me-1"></i> Commandes
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeLivraisons">
                <i class="bi bi-truck me-1"></i> Livraisons
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listePaiements">
                <i class="bi bi-credit-card me-1"></i> Paiements
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex align-items-center" href="index.php?action=listeLivreurs">
                <i class="bi bi-bicycle me-1"></i> Livreurs
              </a>
            </li>
          <?php endif; ?>
        <?php endif; ?>
      </ul>
      
      <!-- Search Form -->
      <form class="d-flex mx-lg-3 my-2 my-lg-0">
        <div class="input-group">
          <input class="form-control bg-light border-0" type="search" placeholder="Search products..." aria-label="Search">
          <button class="btn btn-primary" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
      
      <div class="d-flex align-items-center">
        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == 'client'): ?>
          <a href="index.php?action=viewPanier" class="btn btn-warning btn-sm mx-2">
            <i class="bi bi-cart"></i> Mon Panier
          </a>
        <?php endif; ?>
        <a href="index.php?action=consulterStatistiques" class="btn btn-primary btn-sm mx-2">
            Consulter les Statiques
          </a>
        <a href="?action=disconnect" class="btn btn-danger btn-sm">
          <i class="bi bi-box-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</nav>