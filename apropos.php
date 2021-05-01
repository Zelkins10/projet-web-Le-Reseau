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
    ?>
    <body>
        <!--bandeau réseau-->
        <div class="bandeau">
            <img class="logo">
            <p><a href="index.php">Le Réseau</a></p>
        </div>

        <div class="profil">
            <img src="<?php echo $donnees['photoProfil']; ?>" alt="bug" class="photoprofil">
            <div class="infoprofil">
                <ul class="pseudo"><?php echo $donnees['pseudo']; ?></ul>
                <ul class="info"><?php echo $donnees['prenom']; ?></ul>
                <ul class="info"><?php echo $donnees['nom']; ?></ul>
                <ul class="info"><?php echo $donnees['dateNaissance']; ?></ul>
                <ul class="info"><?php echo $donnees['email']; ?></ul>
                <ul class="info"><?php echo $donnees['bio']; ?></ul>
            </div>
        </div>
        <div class="savoirplus">
            <button class="boutonprofil"><?php echo "<a href='profil.php?pseudo=".$pseudo."'>publications</a>";?></button>
            <button class="boutonprofil">à propos</button>
            <?php if($compte==0){ ?><button class='boutonprofil' onclick="window.location.href='suivre.php?id=<?php echo $id_utilisateur; ?>'">suivre</button> <?php } ?>
        </div>
    </body>