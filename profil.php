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
    $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    $id_utilisateur=$donnees['id'];
    $photoProfil=$donnees['photoProfil'];
?>
    <body>
        <!--partie présentation profil-->
        <div class="profil">
            <img src="<?php echo $donnees['photoProfil']; ?>" alt="bug" class="photoprofil">
            <div class="infoprofil">
                <ul class="pseudo"><?php echo $donnees['pseudo']; ?></ul>
                <ul class="info"><?php echo $donnees['dateNaissance']; ?></ul>
                <ul class="info"><?php echo $donnees['bio']; ?></ul>
            </div>
        </div>
        <div class="savoirplus">
            <button class="boutonprofil">publications</button>
            
            <button class="boutonprofil"><?php echo "<a href='apropos.php?pseudo=".$pseudo."'>à propos</a>";?></button>
            <?php if($compte==0){ ?><button class='boutonprofil' onclick="window.location.href='suivre.php?id=<?php echo $id_utilisateur; ?>'">suivre</button> <?php } ?>
        </div>

        <!--partie fil d'actualité-->
        <div class="fil">
            fil actu, liste de publications
            <?php
                $reponse = $bdd->query('SELECT * FROM IMAC_Publication WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'"');
                while ($donnees = $reponse->fetch()) {
            ?>
                <div class="publication">
                    <div class="profil">
                        <img class="photo" src="<?php echo $photoProfil; ?>">
                        <div class="infoprofil">
                            <div class="auteur"> <?php echo $pseudo ?></div>
                            <div class="date"> <?php echo $donnees['date']; ?></div>
                        </div>
                    </div>
                    <?php 
                        $filename='publication/'.$donnees['id'].'.jpg';
                        if(file_exists($filename)){echo "<img class='photoprofil' src='".$donnees['image']."'>";}
                    ?>
                    <div class="contenu"><?php echo $donnees['texte']; ?></div>
                    <div class="reaction">
                        <?php
                        //echo "<button class='boutonpublication'>Commenter</button>"
                        //<!-- <button onclick="window.location.href = 'https://fr.w3docs.com/';">Ajouter un commentaire</button> -->
                        echo "<a href='publication.php?id=" . $donnees['id'] . "'>
                        <button class='boutonpublication'>Commenter</button>
                        </a>"
                        ?>
                        <button class="boutonpublication">J'aime</button>
                    </div>
                </div>
            <?php 
                }
                $reponse->closeCursor();
            ?>
        </div>

    </body>

</html>