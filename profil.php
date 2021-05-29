<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
    if(isset($_SESSION['pseudo'])){
        $pseudo_courant=$_SESSION['pseudo'];
    }
    $pseudo=$_GET['pseudo'];
    if($pseudo_courant!=$pseudo){
        $compte=0;
    }
    else{
        $compte=1;
    }
    $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo_courant.'"');
    $donnees = $reponse->fetch();
    $id_utilisateur_courant=$donnees['id'];
    $reponse->closeCursor();

    $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $id_utilisateur=$donnees['id'];
    $photoProfil=$donnees['photoProfil'];
    $reponse->closeCursor();
?>
    <body>
        <a href="index.php"><h1>Le Réseau</h1></a>
        <!--partie présentation profil-->
        <div class="profil">
            <?php
                if(file_exists($photoProfil)){
                    echo "<img class='photoprofil' src='".$photoProfil."' alt='bug'>";
                }
            ?>
            <div class="infoprofil">
                <ul class="pseudo"><?php echo $donnees['pseudo']; ?></ul>
                <ul class="info"><?php echo $donnees['bio']; ?></ul>
                <ul class="info">
                <?php
                $reponse3 = $bdd->query('SELECT COUNT(id) AS nbAbonnements FROM IMAC_Suivre WHERE id="'.$id_utilisateur.'"');
                $donnees3 = $reponse3->fetch();
                $reponse3->closeCursor();
                $abonnements = $donnees3['nbAbonnements'];

                $reponse4 = $bdd->query('SELECT COUNT(id) AS nbFollowers FROM IMAC_Suivre WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'"');
                $donnees4 = $reponse4->fetch();
                $reponse4->closeCursor();
                $followers = $donnees4['nbFollowers'];
                
                echo "Suivi(e) par " .$followers. " personnes";
                echo " | Suit " . $abonnements . " personnes";
                ?></ul>
            </div>
        </div>
        <div class="savoirplus">
            <!-- <button class="boutonprofil">publications</button> -->
            <button class="boutonprofil" onclick="window.location.href='apropos.php?pseudo=<?php echo $pseudo; ?>'">à propos</button>
            <?php if($compte==0){ 
                $reponse = $bdd->query('SELECT COUNT(*) as nbFollow FROM IMAC_Suivre WHERE id='.$id_utilisateur_courant.' and id_IMAC_Utilisateur='.$id_utilisateur.'');
                $donnees = $reponse->fetch();
                $nbFollow = $donnees['nbFollow'];
                $reponse->closeCursor();
    
                if($nbFollow==0){
                    ?>
                        <button class='boutonprofil' onclick="window.location.href='suivre.php?id=<?php echo $id_utilisateur; ?>'">suivre</button>
                    <?php
                }
                else{
                    ?>
                        <button class='boutonprofil' onclick="window.location.href='suivre.php?id=<?php echo $id_utilisateur; ?>'">Arrêter de suivre</button>
                    <?php
                }
            ?>
                
            <?php } ?>
        </div>

        <!--partie fil d'actualité-->
        <div class="fil">
            Fil d'actualité, liste de publications
            <?php
                $reponse = $bdd->query('SELECT * FROM IMAC_Publication WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'"');
                while ($donnees = $reponse->fetch()) {
            ?>
                <div class="publication">
                    <div class="profil">
                        <?php
                            if(file_exists($photoProfil)){
                                echo "<img class='photo' src='".$photoProfil."' alt='bug'>";
                            }
                        ?>
                        <div class="infoprofil">
                            <div class="auteur"> <?php echo $pseudo ?></div>
                            <div class="date"> <?php echo $donnees['date']; ?></div>
                        </div>
                    </div>
                    <?php 
                        $filename='publication/'.$donnees['id'].'.jpg';
                        if(file_exists($filename)){
                            echo "<img class='photoprofil' src='".$donnees['image']."'>";
                        }
                    ?>
                    <div class="contenu"><?php echo $donnees['texte']; ?></div>
                    <div class="reaction">
                        <?php
                        // Affichage nb de likes et de comms sur la publication
                //}
                        //$reponse->closeCursor();
                        $reponse2 = $bdd->query('SELECT COUNT(IMAC_AimerPublication.id) AS likes FROM IMAC_AimerPublication JOIN IMAC_Publication ON IMAC_AimerPublication.id = IMAC_Publication.id WHERE IMAC_Publication.id = " '. $donnees['id'] .' " ');
                        $donnees2 = $reponse2->fetch();
                            echo  "👍 " . $donnees2['likes'];
                        
                        $reponse2->closeCursor();
                        $reponse2 = $bdd->query('SELECT COUNT(IMAC_Commentaire.id) AS nbComms FROM IMAC_Commentaire JOIN IMAC_Publication ON IMAC_Commentaire.id_IMAC_Publication = IMAC_Publication.id WHERE IMAC_Publication.id= "' . $donnees['id'] . '"');
                        $donnees2 = $reponse2->fetch();
                            echo "🗨 " . $donnees2['nbComms'];
                        
                        $reponse2->closeCursor();

                        //echo "<button class='boutonpublication'>Commenter</button>"
                        //<!-- <button onclick="window.location.href = 'https://fr.w3docs.com/';">Ajouter un commentaire</button> -->
                        echo "<br><br><a href='publication.php?id=" . $donnees['id'] . "'>
                        <button class='boutonpublication'>Commenter</button>
                        </a>"
                        ?>
                        <!-- Action : like -->
                        <?php
                            $utilisateurCourant = $pseudo_courant;
                            $idPublicationLike = $donnees['id'];
                            $reponseDeja = $bdd->query('SELECT COUNT(*) AS nbLikesEmis FROM IMAC_AimerPublication
                            JOIN IMAC_Publication ON IMAC_AimerPublication.id = IMAC_Publication.id
                            JOIN IMAC_Utilisateur ON IMAC_AimerPublication.id_IMAC_Utilisateur = IMAC_Utilisateur.id
                            WHERE IMAC_Utilisateur.pseudo="'.$utilisateurCourant.'" AND IMAC_Publication.id='.$idPublicationLike.'');
                            $donneesDeja = $reponseDeja->fetch();
                            $reponseDeja->closeCursor();
                            $nbLikesEmis = $donneesDeja['nbLikesEmis'];
                        ?>
                        <div class="reaction">
                            <form method="post" action="ajoutLike.php?id=<?php echo $donnees['id']; ?>" id="like">
                                <input type="submit" value= <?php if($nbLikesEmis == 0){echo "J'aime";} else{echo "Je_n'aime_plus";} ?> />
                            </form>
                        </div>
                    </div>
                </div>
            <?php 
                }
                $reponse->closeCursor();
            ?>
        </div>
    
	    <div id="haut"><a href="#" class="blanc">Aller en haut</a></div>
    </body>

</html>