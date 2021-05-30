<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
    if (isset($_GET['erreur'])){
		$erreur=$_GET['erreur'];
	}
    else{
        $erreur=NULL;
    }
    if($erreur=="aucune"){
        echo "<body><a href='index.php'><h1>Le Réseau</h1></a><p>Vos préférences ont bien été modifiées ".$_SESSION['pseudo']." !</p></body></html>";
    }
    else{
    ?>
	<body>
        <a href="index.php"><h1>Le Réseau</h1></a>
		<?php 
			$reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$_SESSION['pseudo'].'"');
            $donnees = $reponse->fetch();
		?>
        <form class="inscriptionForm" method="post" action="parametres.php" enctype="multipart/form-data">
			<input type="email" name="email" value="<?php echo $donnees['email']; ?>" required> *<br>
			<input type="text" name="pseudo" value="<?php echo $donnees['pseudo']; ?>" required> *<br>
			<input type="password" name="motDePasseActuel" placeholder="Mot de passe actuel" required> *<br>
			<input type="password" name="nouveauMotDePasse" placeholder="Nouveau mot de passe"> (A remplir uniquement si vous souhaitez changer de mot de passe.)<br><br>
			<input type="textarea" name="bio" value="<?php echo $donnees['bio']; ?>"> *<br>
			<input type="file" name="photoProfil"><br>
			<input type="submit" value="Valider"/>
			<input type="reset" value="Annuler"/>
			<br><p>Tous les champs suivis d'une étoile sont obligatoires mais ne nécessitent pas forcément d'être modifiés.</p>
		</form>
		<?php $reponse->closeCursor(); ?>
    <body>
    <p>
		<?php 
			switch($erreur){
				case "pseudoETemail":
					echo "Ce pseudo ET cet email sont déjà utilisés.";
					break;
				case "pseudo":
					echo "Ce pseudo est déjà utilisé.";
					break;
				case "email":
					echo "Cet email est déjà utilisé.";
					break;
				case "mdp":
					echo "Le mot de passe actuel que vous avez saisi ne correspond pas.";
					break;
                }
			}?>
		</p>
	</body>
</html>