<?php
    session_start();
    $id = $_GET['id'];
    include 'bdd.php';
    include 'header.php';

    //$donnees = $reponse->fetch();
    //$reponse = $bdd->query('SELECT IMAC_Publication.id, texte, image, date, id_IMAC_Utilisateur, pseudo, photoProfil FROM IMAC_Utilisateur JOIN IMAC_Publication ON IMAC_Utilisateur.id = id_IMAC_Utilisateur WHERE IMAC_Publication.id=" ' . $id . ' " ');
?>

<body>

    <!-- en-tête Le Réseau-->
    <a href="index.php"><h1>Le Réseau</h1></a>

    <section>
        <article class="publication"> <!-- pour centrer les éléments sur la page -->
            <?php
            // Anciennes requêtes :
            //$reponse = $bdd->query('SELECT * FROM IMAC_Publication WHERE id= " ' . $id . ' " ');
            //$pseudo = $bdd->query('SELECT pseudo FROM IMAC_Utilisateur JOIN IMAC_Publication ON IMAC_Utilisateur.id = id_IMAC_Utilisateur WHERE IMAC_Publication.id=" ' . $id . ' " ');
            
            // requête correcte :
            $reponse = $bdd->query('SELECT IMAC_Publication.id, texte, image, date, id_IMAC_Utilisateur, pseudo, photoProfil FROM IMAC_Utilisateur JOIN IMAC_Publication ON IMAC_Utilisateur.id = id_IMAC_Utilisateur WHERE IMAC_Publication.id="'.$id.'"');
            while($donnees = $reponse->fetch()){
                ?>

                <!-- Auteur de la publication -->
                <div>
                    <a href="profil.php?pseudo=<?php echo $donnees['pseudo']; ?>" class="blanc">
                        <?php
                            if(file_exists($donnees['photoProfil'])){
                                echo "<img class='photo' src='".$donnees['photoProfil']."' alt='bug'>";
                            }
                        ?>
                        <?php echo $donnees['pseudo']; ?>
                    </a>
                </div> <!-- mettre une pp vierge de type "par défaut" à l'auteur s'il n'a pas de pp personnalisée -->

                <!-- <p> -->

                <div>Publié le 
                    <?php echo $donnees['date']; ?> </div>
                <br>

                <div>
                <?php
                    if(file_exists($donnees['image'])){
                        echo "<img class='photoPublication' src='".$donnees['image']."' alt='bug'>";
                    }
                ?>
                </div> 

                 <!-- texte de la publication -->
                <div><?php echo $donnees['texte']; ?></div>
                <br>

                <!-- somme des likes de la publication -->
                <?php
            }
            $reponse->closeCursor();
                ?>
                <?php
                $reponse = $bdd->query('SELECT COUNT(IMAC_AimerPublication.id) AS likes FROM IMAC_AimerPublication JOIN IMAC_Publication ON IMAC_AimerPublication.id = IMAC_Publication.id WHERE IMAC_Publication.id = " '. $id .' " ');
                // ancienne 2e condition de jointure : AND IMAC_AimerPublication.id_IMAC_Utilisateur = IMAC_Publication.id_IMAC_Utilisateur
                while($donnees = $reponse->fetch()){
                    ?>
                    <div><?php echo  "👍 " . $donnees['likes']; ?> </div>
                    <br>
                    <?php
                }

            $reponse->closeCursor();
                ?>
                <?php // Affichage du nb de commentaires postés sur la publication
                $reponse = $bdd->query('SELECT COUNT(IMAC_Commentaire.id) AS nbComms FROM IMAC_Commentaire JOIN IMAC_Publication ON IMAC_Commentaire.id_IMAC_Publication = IMAC_Publication.id WHERE IMAC_Publication.id= "' . $id . '"');
                
                while($donnees = $reponse->fetch()){
                    ?>
                    <div>
                    <?php echo "🗨 " . $donnees['nbComms'];
                    ?>
                    </div>
                    <?php
                }
                
                $reponse->closeCursor();
                ?>
            <br><br>

            <!-- Action : like -->

            <?php
            // Recherche de l'info "est-ce que l'utilisateur a déjà liké la publication ?"
            $utilisateurCourant = $_SESSION['pseudo'];
            $idPublicationLike = $id;
            $reponseDeja = $bdd->query('SELECT COUNT(*) AS nbLikesEmis FROM IMAC_AimerPublication
            JOIN IMAC_Publication ON IMAC_AimerPublication.id = IMAC_Publication.id
            JOIN IMAC_Utilisateur ON IMAC_AimerPublication.id_IMAC_Utilisateur = IMAC_Utilisateur.id
            WHERE IMAC_Utilisateur.pseudo="'.$utilisateurCourant.'" AND IMAC_Publication.id='.$idPublicationLike.'');
            $donneesDeja = $reponseDeja->fetch();
            $reponseDeja->closeCursor();
            $nbLikesEmis = $donneesDeja['nbLikesEmis']; // nb de likes émis par l'utilisateur courant
            
            ?>
            <div class="reaction">
                <form method="post" action="ajoutLike.php?id=<?php echo $id; ?>" id="like">
                    <input type="submit" value= <?php if($nbLikesEmis == 0){echo "J'aime";} else{echo "Je_n'aime_plus";} ?> />
                </form>
            </div>


            <!-- comms de la publication -->

            <div class="Sous-titre">
                Commentaires
            </div>
            <br><br>
            <div> Ajouter un commentaire :</div>
            <form method="post" action="ajoutComm.php?id=<?php echo $id ?>" id="commentaire">
                <br><br>
                <textarea name="comm"
                    placeholder="Votre commentaire..."></textarea>
                <br><br>
                <input type="submit" value="valider" />
            </form>
            <br>

            <?php
            $reponse = $bdd->query('SELECT DISTINCT IMAC_Commentaire.id AS idCommSQL, contenu, date, IMAC_Commentaire.id_IMAC_Utilisateur, id_IMAC_Publication, photoProfil, (SELECT COUNT(*) FROM IMAC_AimerCommentaire WHERE IMAC_AimerCommentaire.id = IMAC_Commentaire.id) AS likesDuComm, pseudo
            FROM IMAC_Commentaire
            LEFT JOIN IMAC_AimerCommentaire ON IMAC_Commentaire.id = IMAC_AimerCommentaire.id
            JOIN  IMAC_Utilisateur ON IMAC_Commentaire.id_IMAC_Utilisateur = IMAC_Utilisateur.id
            WHERE IMAC_Commentaire.id_IMAC_Publication = '.$id.'');

            while($donnees = $reponse->fetch()){
                $idComm = $donnees['idCommSQL'];
                $pseudo = $donnees['pseudo'];
                $comm = $donnees['contenu'];
                $dateEnvoi = $donnees['date'];
                $photoProfil = $donnees['photoProfil'];
            ?>
                <div class="centrer">
                    <p>
                        
                        <!-- pp de l'auteur du comm et son pseudo -->
                        <a href="profil.php?pseudo=<?php echo $pseudo; ?>" class="blanc">
                            <?php
                                if(file_exists($photoProfil)){
                                    echo "<img class='photo' src='".$photoProfil."' alt='bug'>";
                                }
                                echo $pseudo;
                            ?>
                        </a><br> <!-- Lien vers le profil de l'auteur du commentaire -->
                        <!-- Affichage de la date de mise en ligne du commentaire -->
                        <?php echo "(le " . $dateEnvoi . ")" ?>
                        <!-- Bouton pour supprimer le commentaire -->
                        <?php if(isset($_SESSION['pseudo'])){ // Si on est co
                            if(($_SESSION['pseudo'] == "admin") || ($_SESSION['pseudo'] == $pseudo)){ ?> <!-- Si on est l'auteur du comm OU qu'on est l'admin -->
                                <a href="supprComm.php?id=<?php echo $idComm; ?>" onclick="return(confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?'));"> <img src="img/croix.png" class="photo" /> </a>
                        <?php
                            }
                        } ?>

                        <br>
                        <?php
                        echo $comm; // Affichage du texte du commentaire
                        ?>
                        <br>
                        <!-- Affichage du nb de likes du commentaire sous forme de bouton cliquable -->
                        <?php
                        $reponse2 = $bdd->query('SELECT COUNT(IMAC_AimerCommentaire.id) AS likesDuComm FROM IMAC_AimerCommentaire JOIN IMAC_Commentaire ON IMAC_AimerCommentaire.id = IMAC_Commentaire.id WHERE IMAC_Commentaire.id = " '. $idComm .' " ');
                        while($donnees2 = $reponse2->fetch()){
                            ?>
                            <div class="reaction">
                                <form method="post" action="ajoutLikeComm.php?id=<?php echo $idComm ?>" id="like">
                                    <input type="submit" value=<?php echo "👍"  .  $donnees2['likesDuComm']?> />
                                </form>
                            </div>                        
                        </p>

                    </div>
                    <br><br>
                <?php
                        }
                        $reponse2->closeCursor();
            }
            
            $reponse->closeCursor();
            ?>
            <?php
            if(isset($_SESSION['motDePasse'])) {
                $pseudo = $_SESSION['pseudo'];
                $mdp = $_SESSION['motDePasse'];
                if($pseudo == "admin" && $mdp = "mdp") { ?> <!-- si on est l'admin -->

                    <?php
                    $reponse = $bdd->query('SELECT * FROM IMAC_Publication where id=' . $id . '');
                    // Ajouter ici la possibilité de supprimer une publication
                    ?>
                    <br>
                <?php }
            } ?>
        </article>
    </section>
	<div id="haut"><a href="#" class="blanc">Aller en haut</a></div>
</body>
</html>