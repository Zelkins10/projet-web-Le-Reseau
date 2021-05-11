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
		<form class="connexionForm" method="post" action="connexion.php">
			<input type="text" name="pseudo" placeholder="Pseudo" required>
			<input type="password" name="motDePasse" placeholder="Mot de Passe" required><br>
			<input type="submit" value="Valider"/>
			<input type="reset" value="Annuler"/>
		</form>
		<p>
			<?php 
				switch($erreur){
					case "existePas":
						echo "Votre pseudo et/ou votre email ne sont pas enregistré, pour s'inscrire cliquez <a href='formInscription.php'>ici</a>";
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