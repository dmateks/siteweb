<?php
  $connected = false;
  if (isset($_GET['pageSet'])){
    session_destroy();
    $connected = false;
  } else {
    if (isset($_SESSION['sid']) && isset($_SESSION['mdp'])) $connected = true;
    else $connected = false;
  }
  
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
  <div class="container">
    <a class="navbar-brand" href="#">Dmateks</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Accueil
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="connexion.php?pageSet=true">
          <?php echo ($connected ? 'Deconnecion' : 'Connexion'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo ($connected ? 'article' : 'creerCompte'); ?>.php">
          <?php echo ($connected ? 'Créer un article' : 'Créer un compte'); ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
