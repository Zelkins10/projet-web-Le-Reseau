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
        echo "<body><h1><a href='index.php'>Le Réseau</a></h1><p>Bonjour ".$_SESSION['pseudo']." !</p></body></html>";
    }
    else{
?>
	<body>
		<h1><a href="index.php">Le Réseau</a></h1>
		<form method="post" action="connexion.php">
			Pseudo : <input type="text" name="pseudo" required>
			Mot de passe : <input type="password" name="motDePasse" required><br>
			<input type="submit" value="Valider"/>
			<input type="reset" value="Annuler"/>
		</form>
		<p>
			<?php 
				switch($erreur){
					case "existePas":
						echo "Votre pseudo et/ou email ne sont/n'est pas enregistré(s), pour vous inscrire cliquez <a href='formInscription.php'>ici</a>";
						break;
					case "dejaCo":
						echo "Vous êtes déjà connecté en tant que ".$_SESSION['pseudo']." !";
						break;
				}
                echo "<p>Pas de compte ? <a href='formInscription.php'>Inscrivez-vous maintenant !</a></p>";
			}?>
		</p>
	</body>
</html>