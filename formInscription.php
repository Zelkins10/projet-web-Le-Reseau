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
        echo "<body><h1><a href='index.php'>Le Réseau</a></h1><p>Bienvenue ".$_SESSION['pseudo']." !</p></body></html>";
    }
    else{
?>
	<body>
		<h1><a href="index.php">Le Réseau</a></h1>
		<form class="inscriptionForm" method="post" action="inscription.php" enctype="multipart/form-data">
			<input type="email" name="email" placeholder="Adresse Mail" required><br>
			<input type="text" name="pseudo" placeholder="Pseudo" required><br>
			<input type="password" name="motDePasse" placeholder="Mot de Passe" required><br>
			<input type="text" name="prenom" placeholder="Prénom" required><br>
			<input type="text" name="nom" placeholder="Nom" required><br>
			<input type="date" name="dateNaissance" placeholder="Date de Naissance"><br>
			<input type="textarea" name="bio" placeholder="Bio"><br>
			<input type="file" name="photoProfil"><br>
			<input type="submit" value="Valider"/>
			<input type="reset" value="Annuler"/>
		</form>
		<p>
			<?php 
				switch($erreur){
					case "pseudoETemail":
						echo "Votre pseudo ET votre email existe déjà.";
						break;
					case "pseudo":
						echo "Votre pseudo existe déjà.";
						break;
					case "email":
						echo "Votre adresse email existe déjà.";
						break;
					case "dejaCo":
						echo "Vous êtes déjà connecté en tant que ".$_SESSION['pseudo']." !";
						break;
				}
			}?>
		</p>
	</body>
</html>