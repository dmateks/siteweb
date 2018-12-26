<?php

    session_start();

    require_once "config/init.conf.php";
    require_once "config/bdd.conf.php";
    include_once "includes/head.inc.php";

    include "includes/menu.inc.php";

    if(isset($_POST['submit'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = $_POST['mdp'];
        $sid = htmlspecialchars($_POST['sid']);
        $mdp_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

// Création du compte on récupère les informations nom prenom etc 
$req = $bdd->prepare('INSERT INTO utilisateurs(nom, prenom, email, mdp, sid) VALUES(:nom, :prenom, :email, :mdp, :sid)');
$req->execute(array(
   'nom' => $nom,
   'prenom' => $prenom,
   'email' => $email,
   'mdp' => $mdp,
   'sid' => $sid,));
   header('Location: connexion.php');

}

?>


<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Créer un compte</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <form action="creerCompte.php" method="post" enctype="multipart/form-data" id="form_article">
                <div class="form-group">
                    <label for"nom" class="col-from-label">Nom:</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="" value="" required/>
                </div>
                <div class="form-group">
                    <label for"prenom" class="col-from-label">Prénom:</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="" value="" required/>
                </div>
                <div class="form-group">
                    <label for"email" class="col-from-label">Mail:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="" value="" required/>
                </div>
                <div class="form-group">
                    <label for"mdp" class="col-from-label">Mot de passe:</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="" value="" required/>
                </div>
                <div class="form-group">
                    <label for"sid" class="col-from-label">SID:</label>
                    <input type="text" class="form-control" id="sid" name="sid" placeholder="" value="" required/>
                </div>

                <button type="submit" class="btn btn-primary" name="submit" value="creerCompte">Valider l'inscription</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.inc.php' ?>
