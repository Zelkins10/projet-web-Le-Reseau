<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
?>
	<body>
		<h1>Le Réseau</h1>
		<?php
			if(isset($_SESSION['pseudo'])){
				$pseudo=$_SESSION['pseudo'];
				if($_SESSION['pseudo']=="admin"){
					echo "Vous êtes l'administrateur.<br>";
				}
				echo "<a href='formPublication.php'>Nouvelle Publication</a><br>";
				echo "<a href='messagesPrives.php'>Nouveau Message privé</a><br>";
				echo "<a href='profil.php?pseudo=".$pseudo."'>Mon Compte</a><br>";
				echo "<a href='logout.php'>Se déconnecter</a><br>";
				$reponse = $bdd->query('SELECT pseudo,photoProfil,texte,image,date,COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nombrelike
										FROM IMAC_Publication JOIN 
										IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id JOIN
										IMAC_Utilisateur ON IMAC_AimerPublication.id_IMAC_Utilisateur=IMAC_Utilisateur.id 
										WHERE pseudo="'.$pseudo.'" 
										ORDER BY nombrelike');
				
			}
			else{
				echo "<a href='formInscription.php'>S'inscrire</a><br>";
				echo "<a href='formConnexion.php'>Se connecter</a><br>";
				$reponse = $bdd->query('SELECT pseudo,photoProfil,texte,image,date,COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nombrelike
										FROM IMAC_Publication JOIN 
										IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id JOIN
										IMAC_Utilisateur ON IMAC_AimerPublication.id_IMAC_Utilisateur=IMAC_Utilisateur.id 
										ORDER BY nombrelike');
			

			}
			$compteur=0;
			while ($donnees=$response->fetch() OR $compteur>4){
				?>
                <div class="auteurPublication">
                    <?php echo $donnees['pseudo']; ?> </div>
                <br>
                <div class="photoProfilAuteur">
                    <img src="<?php echo $donnees['photoProfil']; ?>" id="photo_profil"> </div> 
                <div class="caracteristiques">Publié le 
                    <?php echo $donnees['date']; ?> </div>
                <br>
                <div class="caracteristiques">
                <img src="<?php echo $donnees['image']; ?>" id="img_publication"></div> 
                <div class="caracteristiques"><?php echo $donnees['texte']; ?></div>
                <br>
				<?php
				$compteur++;
			}
			$reponse->closeCursor();

		?>
	</body>
</html>