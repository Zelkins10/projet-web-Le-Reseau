<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
    $pseudo=$_GET['pseudo'];
    if(isset($_SESSION['pseudo'])){
        $pseudo_courant=$_SESSION['pseudo'];
        if($pseudo_courant!=$pseudo){
            $compte=0;
        }
        else{
            $compte=1;
        }
    }
    else{
        $compte=-1;
    }
    $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    ?>
    <body>
        <a href="index.php"><h1>Le Réseau</h1></a>

        <div class="profil">
            <?php
                if(file_exists($donnees['photoProfil'])){
                    echo "<img class='photoprofil' src='".$donnees['photoProfil']."' alt='bug'>";
                }
            ?>
            <div class="infoprofil">
                <ul class="pseudo"><?php echo $donnees['pseudo']; ?></ul>
                <ul class="info"><?php echo $donnees['bio']; ?></ul>
            </div>
        </div>
        <div class="savoirplus">
            <button class="boutonprofil" onclick="window.location.href='profil.php?pseudo=<?php echo $pseudo; ?>'">publications</button>
            <!-- <button class="boutonprofil">à propos</button> -->
            <?php if($compte==0){ ?><button class='boutonprofil' onclick="window.location.href='suivre.php?id=<?php echo $id_utilisateur; ?>'">suivre</button> <?php } ?>
        </div>
        <ul class="info"><?php echo $donnees['prenom']; ?></ul>
        <ul class="info"><?php echo $donnees['nom']; ?></ul>
        <ul class="info"><?php echo "Né(e) le " . $donnees['dateNaissance']; ?></ul>
    </body>