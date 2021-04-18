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
		<form method="post" action="inscription.php" enctype="multipart/form-data">
			E-mail : <input type="email" name="email" required><br>
			Nom d'utilisateur : <input type="text" name="pseudo" required><br>
			Mot de passe : <input type="password" name="motDePasse" required><br>
			Prénom : <input type="text" name="prenom" required><br>
			Nom : <input type="text" name="nom" required><br>
			Date de Naissance : <input type="date" name="dateNaissance"><br>
			Bio : <input type="textarea" name="bio"><br>
			Photo de profil : <input type="file" name="photoProfil"><br>
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