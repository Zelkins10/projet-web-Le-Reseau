<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
?>
	<body>
		<form method="post" action="inscription.php">
			E-mail : <input type="email" name="email" required><br>
			Nom d'utilisateur : <input type="text" name="pseudo" required><br>
			Mot de passe : <input type="password" name="motDePasse" required><br>
			Prénom : <input type="text" name="prenom" required><br>
			Nom : <input type="text" name="nom" required><br>
			Date de Naissance : <input type="date" name="dateNaissance"><br>
			Bio : <input type="text" name="bio"><br>
			Photo de profil : <input type="file" name="photoProfil"><br>
			<input type="submit" value="Valider"/>
			<input type="reset" value="Annuler"/>
		</form>
	</body>
</html>