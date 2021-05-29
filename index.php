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
				
				$reponse = $bdd->query('SELECT id FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
				$donnees = $reponse->fetch();
				$id=$donnees['id'];
				$reponse->closeCursor();

				$reponse = $bdd->query('SELECT COUNT(*) as nb FROM IMAC_Suivre WHERE id='.$id.'');
				$donnees = $reponse->fetch();
				$nb=$donnees['nb'];
				$reponse->closeCursor();

				if($nb>0){
					echo "<br> Regardez ce qu'ont publié les utilisateurs que vous suivez : ";
				}

				$reponse = $bdd->query('SELECT SUIVEUR.pseudo AS suiveur,SUIVIS.pseudo AS suivis,SUIVIS.photoProfil AS photo,date,texte,image, IMAC_Publication.id AS idPub
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
						//echo "<a href='supprPublication.php?id="$donnees['IMAC_Publication.id']"'>"; // PROBLEME ICI <- (il faut créer le fichier)
					}?>
						<a href="profil.php?pseudo=<?php echo $donnees['suivis']; ?>">
							<?php
								if(file_exists($donnees['photo'])){
									echo "<img class='photo' src='".$donnees['photo']."' alt='bug'>";
								}
							?>
							<?php echo $donnees['suivis']; ?>
						</a>
					</div>
					<a href="publication.php?id=<?php echo $donnees['idPub']; ?>">
						<div class="caracteristiques">	
							<?php echo $donnees['date']; ?> </div>
						<div class="caracteristiques">
							<?php
								if(file_exists($donnees['image'])){
									echo "<img class='photoPublication' src='".$donnees['image']."' alt='bug'>";
								}
							?>
						<div class="caracteristiques"><?php echo $donnees['texte']; ?></div>
						</div>
					</a>
					</div>
					<?php
				}
				$reponse->closeCursor();
				$reponse = $bdd->query('SELECT pseudo,photoProfil,date,texte,image, COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nblike, IMAC_Publication.id AS idPub 
										FROM IMAC_Utilisateur JOIN 
											 IMAC_Publication ON IMAC_Utilisateur.id=IMAC_Publication.id_IMAC_Utilisateur JOIN
											 IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id 
										GROUP BY IMAC_AimerPublication.id 
										ORDER BY nblike DESC 
										LIMIT 20');
				
			}
			else{
				echo "<div class='débuterSurLeSite'>";
				echo "<a href='formInscription.php' class='linkHomepage'>Inscription</a><br>";
				echo "<a href='formConnexion.php' class='linkHomepage'>Connexion</a>";
				echo "</div>";
				$reponse = $bdd->query('SELECT pseudo,photoProfil,date,texte,image, COUNT(IMAC_AimerPublication.id_IMAC_Utilisateur) AS nblike, IMAC_Publication.id AS idPub
										FROM IMAC_Utilisateur JOIN
											 IMAC_Publication ON IMAC_Utilisateur.id=IMAC_Publication.id_IMAC_Utilisateur JOIN
											 IMAC_AimerPublication ON IMAC_AimerPublication.id=IMAC_Publication.id
										GROUP BY IMAC_AimerPublication.id
										ORDER BY nblike DESC
										LIMIT 3');
			}
			
			echo "<br> Venez découvrir les autres utilisateurs du Réseau : ";
			while ($donnees=$reponse->fetch()){
				?>
                <div class="publications">
				<div class="auteurPublication">
				<?php if($_SESSION['pseudo']=="admin"){
					//echo "<a href='supprPublication.php?id="$donnees['IMAC_Publication.id']"'>"; // PROBLEME ICI
				}?>
                    <a href="profil.php?pseudo=<?php echo $donnees['pseudo']; ?>">
						<?php
							if(file_exists($donnees['photoProfil'])){
								echo "<img class='photo' src='".$donnees['photoProfil']."' alt='bug'>";
							}
						?>
						<?php echo $donnees['pseudo']; ?>
					</a>
				</div>
				<a href="publication.php?id=<?php echo $donnees['idPub']; ?>">
					<div class="caracteristiques">
						<?php echo $donnees['date']; ?>
					</div>
					<div class="caracteristiques">
						<?php
							if(file_exists($donnees['image'])){
								echo "<img class='photoPublication' src='".$donnees['image']."' alt='bug'>";
							}
						?>
						<div class="caracteristiques"><?php echo $donnees['texte']; ?></div>
					</div>
				</a>
				</div>
				<?php
			}
			$reponse->closeCursor();

		?>
		<div id="haut"><a href="#" class="blanc">Aller en haut</a></div>
	</body>
</html>