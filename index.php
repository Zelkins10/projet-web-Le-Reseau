<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
?>
	<body>
		<h1>Le Réseau</h1>
		<div class="barre">
			<form method="post" action="recherche.php" class="form-inline">
				<input class="recherche" type="text" name="barre" placeholder="Saisir pseudo à rechercher" required />
				<input type="submit" value="valider"/>
			</form>
		</div>
		<?php
			if(isset($_SESSION['pseudo'])){
				$pseudo=$_SESSION['pseudo'];
				if($_SESSION['pseudo']=="admin"){
					echo "Vous êtes l'administrateur.<br>";
				}
				echo "<div class='websiteInteractions'>";
				echo "<a class='linkHomepage' href='formPublication.php'>Nouvelle publication</a>";
				echo "<a class='linkHomepage' href='messagesPrives.php'>Messages privés</a>";
				echo "<a class='linkHomepage' href='profil.php?pseudo=".$pseudo."'>Mon compte</a>";
				echo "<a class='linkHomepage' href='formParametres.php'>Paramètres</a>";
				echo "<a class='linkHomepage' href='logout.php'>Se déconnecter</a>";
				echo "</div>";
				$reponse = $bdd->query('SELECT pseudo,photoProfil,texte,image,date,COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nombrelike
										FROM IMAC_Publication JOIN 
										IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id JOIN
										IMAC_Utilisateur ON IMAC_AimerPublication.id_IMAC_Utilisateur=IMAC_Utilisateur.id 
										WHERE pseudo="'.$pseudo.'" 
										ORDER BY nombrelike 
										LIMIT 4');
				
			}
			else{
				echo "<div class='débuterSurLeSite'>";
				echo "<div class='boutonsDébuterSurLeSite'>";
				echo "<a href='formInscription.php'>Inscription</a><br>";
				echo "</div>";
				echo "<div class='boutonsDébuterSurLeSite'>";
				echo "<a href='formConnexion.php'>Connexion</a>";
				echo "</div>";
				echo "</div>";
				$reponse = $bdd->query('SELECT IMAC_Publication.id, pseudo,photoProfil,texte,image,date,COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nombrelike
										FROM IMAC_Publication JOIN 
										IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id JOIN
										IMAC_Utilisateur ON IMAC_AimerPublication.id_IMAC_Utilisateur=IMAC_Utilisateur.id 
										ORDER BY nombrelike
										LIMIT 4');
			

			}

			while ($donnees=$reponse->fetch()){
				?>
                <div class="publications">
				<div class="auteurPublication">
				<?php if($_SESSION['pseudo']=="admin"){
					//echo "<a href='supprPublication.php?id="$donnees['IMAC_Publication.id']"'>"; // PROBLEME ICI
				}?>
                    <?php echo $donnees['pseudo']; ?> </div>
                <div class="photoProfilAuteur">
                    <img src="<?php echo $donnees['photoProfil']; ?>" id="photo_profil" class="photo"> </div> 
                <div class="caracteristiques">
                    <?php echo $donnees['date']; ?> </div>
                <div class="caracteristiques">
                <img src="<?php echo $donnees['image']; ?>" id="img_publication"></div> 
                <div class="caracteristiques"><?php echo $donnees['texte']; ?></div>
				</div>
				<?php
			}
			$reponse->closeCursor();

		?>
	</body>
</html>