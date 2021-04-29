<?php

session_start();
$id = $_SESSION['id'];
$pseudo = $_SESSION['pseudo'];

if(!isset($pseudo)){
    header('location: formConnexion.php');
}

else{
	
    header('location: publication.php?id='.$id.'');

        include 'bdd.php';

        $reponse = $bdd->query('SELECT COUNT(*) AS nbLikes FROM IMAC_AimerPublication
        JOIN IMAC_Publication ON IMAC_AimerPublication.id = IMAC_Publication.id
        WHERE id_IMAC_Utilisateur="'.$pseudo.'" AND IMAC_Publication.id='.$id.'');
        $donnees = $reponse->fetch();
        $reponse->closeCursor();
        $nbLikes = $donnees['nbLikes'];

        if($nbLikes == 0){ // Un utilisateur ne peut pas ajouter plus de 1 like sur une même publication
            $reponse = $bdd->query('SELECT id AS idUser FROM IMAC_Utilisateur WHERE pseudo= "'.$_SESSION['pseudo'].'"');
            $donnees = $reponse->fetch();
            $reponse->closeCursor();
            $idUser = $donnees['idUser'];

            $reponse = $bdd->query('INSERT INTO IMAC_AimerPublication(id, id_IMAC_Utilisateur) VALUES('.$id.', "'.$idUser.'", )');
            header ('location: publication.php?id='.$id.'');
        }

        else{ 
            echo"<html><body>";
            echo"<script language=\"javascript\">";
            echo"alert('Vous aimez déjà cette publication.');";
            echo"document.location.href = 'publication.php?id=".$id."';";
            echo"</script>";
            echo"</body></html>";
        }
};

?> 