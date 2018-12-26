<!DOCTYPE html>
<html lang="en">

    <?php
        require_once "config/init.conf.php";
        require_once "config/bdd.conf.php";
        include_once "includes/head.inc.php";
        session_start();

        if(isset($_SESSION['notifications'])) {
            $color_notification = $_SESSION['notifications']['result'] == true ? "success" : "danger";
        }
    ?>

    <body>

        <?php include_once "includes/menu.inc.php" ?>

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="mt-5">Dmateks</h1>
                    <?php if(isset($_SESSION['notifications'])) { ?>
                        <div class="alert alert-<?php echo $color_notification; ?> alert-dismissible fade show" role="alert">
                            <?php
                                    echo $_SESSION['notifications']['message'];
                                    unset($_SESSION['notifications']);
                             ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                </div>


                    <?php

                        
                        $select_article = "SELECT article.Id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') as date, publie FROM article WHERE publie=:publie";
                       
                        //Préparation de la requête
                        $sth = $bdd->prepare($select_article);

                        //Sécuriser les paramètres, qui a comme valeur 1, et doit être un booléen
                        $sth->bindValue(":publie", 1, PDO::PARAM_BOOL);

                        //Exécution de la requête
                        $sth->execute();

                        //Association des enregistrements
                        $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); //fetch nous sert a recuperer toutes les informations de la BDD 
                    ?>
            </div>

            <div class="row">
                <?php
                    foreach ($tab_articles as $key => $value) {
                        ?>
                            <div class="col-md-6">
                                <div class="card mt-4">
                                    <img class="card-img-top" src="img/<?php echo $value['Id']; ?>.jpg" alt="<?php echo $value['Id']; ?>"/>
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $value['titre']; ?></h4>
                                        <p class="card-text"><?php echo $value['texte']; ?></p>
                                        <h5>Créé le : <?php echo $value['date']; ?></h5>
                                        <form id="del-article" method="post" action="index.php?delId=<?php echo $value['Id']; ?>" role="form">
                                            <input type="submit" name="del" class="button1" value="Supprimer Article">
                                        </form>
                                        <?php
                                
                                            $select_comments = "SELECT * FROM comments WHERE idarticle = :idarticle";
                                            /* @var $bdd PDO */
                            
                                            $sth = $bdd->prepare($select_comments);

                                            $sth->bindValue(":idarticle", $value['Id'], PDO::PARAM_INT);

                                            //Exécution de la requête
                                            $sth->execute();

                                            //Association des enregistrements
                                            $tab_comments = $sth->fetchAll(PDO::FETCH_ASSOC); 
                                            foreach ($tab_comments as $key => $comment) {
                                                ?>
                                        <div id="soum-comment">
                                            <h5>Peudo : <?php echo $comment['pseudo']; ?></h5>
                                            <h5>Mail : <?php echo $comment['mail']; ?></h5>
                                            <p><?php echo $comment['comment']; ?></p>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                     
                                    
                                                          <!-- Insertion commentaire en HTML  Pseudo Mail etc  -->
                                    <form id="soum-comment" method="post" action="index.php?idarticle=<?php echo $value['Id']; ?>" role="form">
                                      <div>
                                        <label for="pseudo">Pseudo</label>
                                        <input id="pseudo" type="text" name="pseudo" class="form-control" placeholder="Votre pseudo">
                                      </div>
                                      <div>
                                        <label for="mail">Mail</label>
                                        <input id="mail" type="email" name="mail" class="form-control" placeholder="Votre adresse mail">
                                      </div>
                                      <div>
                                        <label for="comments">Commentaire </label>
                                        <textarea id="comments" name="comments" class="form-control" placeholder="Votre Commentaire" rows="4"></textarea>
                                      </div>
                                      <div>
                                            <input type="submit" name="add" class="button1" value="Envoyer">
                                      </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                    }
                ?>

            </div>

        </div>

        <?php
          
          if (isset($_POST['add'])){
            $inserer_article = "INSERT INTO commentaire(pseudo, mail, commentaire, idarticle) VALUES (:pseudo, :mail, :commentaire, :idarticle)";
            // Envois les informations dans la base de donnée dans la table commenaitre on a les informations ( Pseudo etc)

            //Préparation de la requête
            $sth = $bdd->prepare($inserer_article);
    
      
            $sth->bindValue(":pseudo", $_POST['pseudo'], PDO::PARAM_STR);
            $sth->bindValue(":mail", $_POST['mail'], PDO::PARAM_STR);
            $sth->bindValue(":commentaire", $_POST['commentaire'], PDO::PARAM_STR);
            $sth->bindValue(":idarticle", $_GET['idarticle'], PDO::PARAM_INT);
    
            // Pour supprimer un article on fait la requête si dessous : 
          }
          else if(isset($_POST['del'])){
            $supprimer_article = "DELETE article, comments FROM article LEFT OUTER JOIN comments ON article.id = comments.idarticle WHERE article.Id =:idarticle";
            $sth = $bdd->prepare($supprimer_article);
            $sth->bindValue(":idarticle", $_GET['delId'], PDO::PARAM_INT);
            $result = $sth->execute();
            echo "<meta http-equiv='refresh' content='0'>";
          }


        ?>

        <?php include 'includes/footer.inc.php' ?>

    </body>

</html>
