<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
    if(isset($_SESSION['pseudo'])){
        $pseudo=$_SESSION['pseudo'];
    }
    $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    $id_utilisateur=$donnees['id'];
    $photoProfil_utilisateur=$donnees['photoProfil'];
    $id_destinataire=$_GET['id'];
?>
    <body>
        <a href="index.php"><h1>Le Réseau</h1></a>
        <?php
            $reponse = $bdd->query('SELECT pseudo, photoProfil, image, texte, date, id_IMAC_Utilisateur FROM IMAC_MessagePrive mp JOIN IMAC_Utilisateur u ON mp.id_IMAC_Utilisateur=u.id WHERE (id_IMAC_Utilisateur="'.$id_utilisateur.'" and id_IMAC_Utilisateur_Recevoir="'.$id_destinataire.'") or (id_IMAC_Utilisateur="'.$id_destinataire.'" and id_IMAC_Utilisateur_Recevoir="'.$id_utilisateur.'")');
            while ($donnees = $reponse->fetch()) {
                echo "<img class='photo' src='".$donnees['photoProfil']."'>";
                echo "<a href='profil.php?pseudo=".$donnees['pseudo']."'>".$donnees['pseudo']."</a><br>";
                echo "<p><img class='photo' src='".$donnees['image']."'>";
                echo $donnees['texte']."</p><br>";
            }
            $reponse->closeCursor();
        ?>
        
        <form method="post" action="envoyerMessage.php?id=<?php echo $id_destinataire; ?>" enctype="multipart/form-data">
            Texte : <input type="textarea" name="texte" required><br>
            Image : <input type="file" name="image"><br>
            <input type="submit" value="Valider"/>
            <input type="reset" value="Annuler"/>
		</form>
    </body>
</html>