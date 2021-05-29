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
        <a href="index.php"><h1>Le Réseau</h1></a>
        <div class="vosmessages">
            <p>Vos Messages</p>
        </div>
        <div class="centrer">
        <?php
            $reponse = $bdd->query('SELECT id_IMAC_Utilisateur_Recevoir, pseudo, photoProfil, id_IMAC_Utilisateur FROM IMAC_MessagePrive mp JOIN IMAC_Utilisateur u ON mp.id_IMAC_Utilisateur_Recevoir=u.id WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'"');
            echo "<div class='listeMessages'>";
            while ($donnees = $reponse->fetch()) {
                echo "<div class='destinataires'>";
                echo "<img class='photo' src='".$donnees['photoProfil']."'>";
                echo "<a href='messagePrive.php?id=".$donnees['id_IMAC_Utilisateur_Recevoir']."'>".$donnees['pseudo']."</a>";
                echo "</div>";
            }
            echo "</div>";
            $reponse->closeCursor();
            $reponse = $bdd->query('SELECT COUNT(*) as nb FROM IMAC_MessagePrive mp JOIN IMAC_Utilisateur u ON mp.id_IMAC_Utilisateur=u.id WHERE id_IMAC_Utilisateur_Recevoir="'.$id_utilisateur.'"');
            $donnees = $reponse->fetch();
            if($donnees['nb']==0){
                echo "Personne ne vous a encore contacté, essayez par vous même :<br><br>";
            }
            else{
                echo "<hr><p>".$donnees['nb']." personnes cherchent à vous contacter :</p><br>";
            }
            
            $reponse->closeCursor();
            
            $reponse = $bdd->query('SELECT pseudo, photoProfil, id_IMAC_Utilisateur FROM IMAC_MessagePrive mp JOIN IMAC_Utilisateur u ON mp.id_IMAC_Utilisateur=u.id WHERE id_IMAC_Utilisateur_Recevoir="'.$id_utilisateur.'"');
            while ($donnees = $reponse->fetch()) {
                $reponse2 = $bdd->query('SELECT COUNT(*) as nb FROM IMAC_MessagePrive WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'" and id_IMAC_Utilisateur_Recevoir="'.$donnees['id_IMAC_Utilisateur'].'"');
                $donnees2 = $reponse2->fetch();
                $reponse2->closeCursor();
                if($donnees2['nb']==0){
                    echo "<img class='photo' src='".$donnees['photoProfil']."'>";
                    echo "<a href='messagePrive.php?id=".$donnees['id_IMAC_Utilisateur']."'>".$donnees['pseudo']."</a>";
                } 
            }
            $reponse->closeCursor();
        ?>

        <button onclick="window.location.href='nouveauMessage.php'">Nouveau Message</button><br>
        </div>
    </body>
</html>