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
            $reponse = $bdd->query('SELECT DISTINCT id_IMAC_Utilisateur_Recevoir, pseudo, photoProfil, id_IMAC_Utilisateur FROM IMAC_MessagePrive mp JOIN IMAC_Utilisateur u ON mp.id_IMAC_Utilisateur_Recevoir=u.id WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'"');
            echo "<div class='listeMessages'>";
            while ($donnees = $reponse->fetch()) {
                echo "<div class='destinataires'>";
                echo "<a href='messagePrive.php?id=".$donnees['id_IMAC_Utilisateur_Recevoir']."' class='blanc'>";
				if(file_exists($donnees['photoProfil'])){
					echo "<img class='photo' src='".$donnees['photoProfil']."'>";
				}
                echo $donnees['pseudo']."</a>";
                echo "</div>";
            }
            echo "</div>";
            $reponse->closeCursor();
            $nb=0; //nombre de personnes qui cherchent à nous contacter 
            $reponse = $bdd->query('SELECT id_IMAC_Utilisateur FROM IMAC_MessagePrive mp JOIN IMAC_Utilisateur u ON mp.id_IMAC_Utilisateur=u.id WHERE id_IMAC_Utilisateur_Recevoir="'.$id_utilisateur.'"');
            while ($donnees = $reponse->fetch()) {

                //id_utilisateur = utilisateur courant ---- id_IMAC_Utilisateur = utilisateur qui nous a envoyé le message
                $reponse2 = $bdd->query('SELECT COUNT(*) as nb FROM IMAC_MessagePrive WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'" and id_IMAC_Utilisateur_Recevoir="'.$donnees['id_IMAC_Utilisateur'].'"');
                $donnees2 = $reponse2->fetch();
                if($donnees2['nb']==0){ // nombre de messages que nous avons envoyé à cette personne qui nous a envoyé un message
                    $nb=$nb+1;
                }

            }

            $reponse2->closeCursor();
            $reponse->closeCursor();

            if($nb==0){
                echo "<br><br>Aucune nouvelle personne cherche à vous contacter, essayez par vous même :<br><br>";
            }
            else{
                echo "<hr><p>".$nb." personnes cherchent à vous contacter :</p><br>";
            }

            $reponse = $bdd->query('SELECT pseudo, photoProfil, id_IMAC_Utilisateur FROM IMAC_MessagePrive mp JOIN IMAC_Utilisateur u ON mp.id_IMAC_Utilisateur=u.id WHERE id_IMAC_Utilisateur_Recevoir="'.$id_utilisateur.'"');
            while ($donnees = $reponse->fetch()) {
                $reponse2 = $bdd->query('SELECT COUNT(*) as nb FROM IMAC_MessagePrive WHERE id_IMAC_Utilisateur="'.$id_utilisateur.'" and id_IMAC_Utilisateur_Recevoir="'.$donnees['id_IMAC_Utilisateur'].'"');
                $donnees2 = $reponse2->fetch();
                $reponse2->closeCursor();
                if($donnees2['nb']==0){
                    echo "<a href='messagePrive.php?id=".$donnees['id_IMAC_Utilisateur']."' class='blanc'>";
                    if(file_exists($donnees['photoProfil'])){
                        echo "<img class='photo' src='".$donnees['photoProfil']."'>";
                    }
                    echo $donnees['pseudo']."</a>";
                } 
            }
            $reponse->closeCursor();
        ?>

        <button onclick="window.location.href='nouveauMessage.php'">Nouveau Message</button><br>
        </div>
    </body>
</html>