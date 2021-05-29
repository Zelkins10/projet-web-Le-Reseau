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
?>
    <body>
        <?php
            $reponse = $bdd->query('SELECT id_IMAC_Utilisateur, pseudo, photoProfil FROM IMAC_Suivre s JOIN IMAC_Utilisateur u ON s.id_IMAC_Utilisateur=u.id WHERE s.id="'.$id_utilisateur.'"');
            while ($donnees = $reponse->fetch()) {
                if(file_exists($donnees['photoProfil'])){
                    echo "<img class='photo' src='".$donnees['photoProfil']."' class='photoprofil' alt='bug'>";
                }
                echo "<a href='messagePrive.php?id=".$donnees['id_IMAC_Utilisateur']."'>".$donnees['pseudo']."</a>";
            }
            $reponse->closeCursor();
        ?>
    </body>
</html>