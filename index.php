<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
?>
	<body>
		<h1>Le Réseau</h1>
		<?php
			if(isset($_SESSION['pseudo'])){
				if($_SESSION['pseudo']=="admin"){
					echo "Vous êtes l'administrateur.";
				}
				echo "<a href='logout.php'>Se déconnecter</a>";
			}
			else{
				echo "<a href='formInscription.php'>S'inscrire</a><br>";
				echo "<a href='formConnexion.php'>Se connecter</a>";
			}
		?>
	</body>
</html>