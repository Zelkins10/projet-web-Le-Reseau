<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
	if (isset($_GET['erreur'])){
		$erreur=$_GET['erreur'];
	}
?>
	<body>
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
		<p><?php if(isset($erreur)){
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
			}
		}?></p>
	</body>
</html>