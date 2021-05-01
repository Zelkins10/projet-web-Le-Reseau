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
				echo "<a href='logout.php'>Se déconnecter</a>";
				$reponse = $bdd->query('SELECT * FROM IMAC_Publication JOIN
					 						IMAC_AimerPublication ON id.IMAC_AimerPublication=id.IMAC_Publication JOIN
											IMAC_Utilisateur ON id_IMAC_Utilisateur.IMAC_AimerPublication=id.IMAC_Utilisateur
											WHERE MAX(COUNT(
												SELECT * FROM IMAC_Utilisateur JOIN 
												IMAC_AimerPublication ON id.IMAC_Utilisateur=id.IMAC_AimerPublication) 
												WHERE pseudo="'.$pseudo.'"');
				
			}
			else{
				echo "<a href='formInscription.php'>S'inscrire</a><br>";
				echo "<a href='formConnexion.php'>Se connecter</a>";
				$reponse = $bdd->query('SELECT * FROM IMAC_Publication JOIN
										IMAC_AimerPublication ON id.IMAC_AimerPublication=id.IMAC_Publication JOIN
			   							IMAC_Utilisateur ON id_IMAC_Utilisateur.IMAC_AimerPublication=id.IMAC_Utilisateur
			   							WHERE MAX(COUNT(
				   							SELECT * FROM IMAC_Utilisateur JOIN 
								 			IMAC_AimerPublication ON id.IMAC_Utilisateur=id.IMAC_AimerPublication) 
				   							WHERE pseudo="'.$pseudo.'"');
			}
			$compteur=0;
			while($donnees=$response->fetch() OR $compteur>4){

				echo $donnees['photoProfil']; 
				echo $donnees['pseudo'];
				echo $donnees['texte'];
				echo $donnees['image'];
				$compteur++;
			}

		?>
	</body>
</html>