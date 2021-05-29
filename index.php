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

				$reponse = $bdd->query('SELECT SUIVEUR.pseudo AS suiveur,SUIVIS.pseudo AS suivis,SUIVIS.photoProfil AS photo,date,texte,image 
										FROM IMAC_Utilisateur AS SUIVEUR JOIN 
											 IMAC_Suivre ON SUIVEUR.id=IMAC_Suivre.id JOIN 
											 IMAC_Utilisateur AS SUIVIS ON SUIVIS.id=IMAC_Suivre.id_IMAC_Utilisateur JOIN 
											 IMAC_Publication ON IMAC_Publication.id_IMAC_Utilisateur=SUIVIS.id
										WHERE SUIVEUR.pseudo="' . $pseudo . '"
										ORDER BY date DESC
										LIMIT 20'); 

				while ($donnees=$reponse->fetch()){
					?>
					<div class="publications">
					<div class="auteurPublication">
					<?php if($_SESSION['pseudo']=="admin"){
						//echo "<a href='supprPublication.php?id="$donnees['IMAC_Publication.id']"'>"; // PROBLEME ICI
					}?>
						<?php echo $donnees['suivis']; ?> </div>
					<div class="photoProfilAuteur">
						<img src="<?php echo $donnees['photo']; ?>" id="photo_profil" class="photo"> </div> 
					<div class="caracteristiques">
						<?php echo $donnees['date']; ?> </div>
					<div class="caracteristiques">
					<img src="<?php echo $donnees['image']; ?>" id="img_publication"></div> 
					<div class="caracteristiques"><?php echo $donnees['texte']; ?></div>
					</div>
					<?php
				}
				$reponse->closeCursor();
				$reponse = $bdd->query('SELECT pseudo,photoProfil,date,texte,image, COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nblike 
										FROM IMAC_Utilisateur JOIN 
											 IMAC_Publication ON IMAC_Utilisateur.id=IMAC_Publication.id_IMAC_Utilisateur JOIN
											 IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id 
										GROUP BY IMAC_AimerPublication.id 
										ORDER BY nblike DESC 
										LIMIT 20');
				
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
				$reponse = $bdd->query('SELECT pseudo,photoProfil,date,texte,image, COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nblike 
										FROM IMAC_Utilisateur JOIN 
											 IMAC_Publication ON IMAC_Utilisateur.id=IMAC_Publication.id_IMAC_Utilisateur JOIN
											 IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id 
										GROUP BY IMAC_AimerPublication.id 
										ORDER BY nblike DESC 
										LIMIT 3 ');
			

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