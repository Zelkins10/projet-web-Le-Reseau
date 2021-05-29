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
        echo "<body><h1><a href='index.php'>Le Réseau</a></h1><p>Vos préférneces ont bien été modifiées ".$_SESSION['pseudo']." !</p></body></html>";
    }
    else{
    ?>
	<body>
        <a href="index.php"><h1>Le Réseau</h1></a>
        <form class="inscriptionForm" method="post" action="inscription.php" enctype="multipart/form-data">
			<input type="email" name="email" placeholder="Adresse Mail" required><br>
			<input type="text" name="pseudo" placeholder="Pseudo" required><br>
			<input type="password" name="motDePasse" placeholder="Mot de Passe" required><br>
			<input type="textarea" name="bio" placeholder="Bio"><br>
			<input type="file" name="photoProfil"><br>
			<input type="submit" value="Valider"/>
			<input type="reset" value="Annuler"/>
		</form>
    <body>
    <p>
		<?php 
			switch($erreur){
				case "pseudoETemail":
					echo "Ce pseudo ET cet email sont déjà utilisés.";
					break;
				case "pseudo":
					echo "Ce pseudo est déjà utilisé.";
					break;
				case "email":
					echo "Cet email est déjà utilisé.";
					break;
                }
			}?>
		</p>
	</body>
</html>