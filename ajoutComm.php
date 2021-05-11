<?php

session_start();
$id = $_SESSION['id'];
$pseudo = $_SESSION['pseudo'];

include 'bdd.php';

//récup de l'id de l'utilisateur courant :
$reponse = $bdd->query('SELECT id FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
$donnees = $reponse->fetch();
$reponse->closeCursor();
$idUser = $donnees['id'];

if(!isset($pseudo)){
    header('location: formConnexion.php?id='.$id.'');
}

else{

    if(!isset($_POST['contenu'])){	
    header('location: publication.php?id='.$id.'');
}

    else{
        $comm = htmlspecialchars($_POST['contenu']);

        $reponse = $bdd->query('SELECT COUNT(*) AS nbComms FROM IMAC_Commentaire WHERE id_IMAC_Utilisateur="'.$pseudo.'" AND id_IMAC_Publication='.$id.'');
        $donnees = $reponse->fetch();
        $reponse->closeCursor();
        $nbComms = $donnees['nbComms'];

        if($nbComms < 999){ // Un utilisateur ne peut pas poster plus de 999 commentaires sur une même publication
            $reponse = $bdd->query('INSERT INTO IMAC_Commentaire(contenu, date, id_IMAC_Utilisateur, id_IMAC_Publication) VALUES("'.$comm.'", CURDATE(), '.$idUser.', '.$id.')');
            header ('location: publication.php?id='.$id.'');
        }

        else{ 
            echo"<html><body>";
            echo"<script language=\"javascript\">";
            echo"alert('Vous ne pouvez pas commenter plus de 999 fois la même publication.');";
            echo"document.location.href = 'publication.php?id=".$id."';";
            echo"</script>";
            echo"</body></html>";
        }
    }
};

?> 