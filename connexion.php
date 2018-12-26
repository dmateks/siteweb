

<?php

    session_start();

    require_once "config/init.conf.php";
    require_once "config/bdd.conf.php";
    include_once "includes/head.inc.php";

    include "includes/menu.inc.php";

?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Se connecter</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <form action="connexion.php" method="post" enctype="multipart/form-data" name="form_article" id="form_article">
                <div class="form-group">
                    <label for"login" class="col-from-label">Identifiant:</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Votre identifiant" value="" required/>
                </div>
                <div class="form-group">
                    <label for"mdp" class="col-from-label">Mot de passe:</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="" value="" required/>
                </div>
                <button type="submit" class="btn btn-primary" name="submit" value="connecter">Se connecter</button>
            </form>
        </div>
    </div>
</div>

           
<?php
 
    // Partie connexion Base de Donnée et SiteWeb on récupère les informations dans la table Utilisateurs 
   // 
    if(isset($_POST['login']) && isset($_POST['mdp'])){
        $bdd = new PDO('mysql:host=localhost;dbname=monblog;charset=utf8','root','');
        $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE sid = ?;');
        $req->execute(array($_POST['login']));
        $data= $req->fetch();
        if($data['sid'] == $_POST['login'] && $data['mdp'] == $_POST['mdp']){
            $_SESSION['sid'] = $data['sid'];
            $_SESSION['mdp'] = $data['mdp'];
            header('Location: article.php');
            exit();
        } 
    }
    exit();
?>

<?php include 'includes/footer.inc.php' ?>
