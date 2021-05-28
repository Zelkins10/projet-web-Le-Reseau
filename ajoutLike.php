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
        JOIN IMAC_Utilisateur ON IMAC_AimerPublication.id_IMAC_Utilisateur = IMAC_Utilisateur.id
        WHERE IMAC_Utilisateur.pseudo="'.$pseudo.'" AND IMAC_Publication.id='.$id.'');
        $donnees = $reponse->fetch();
        $reponse->closeCursor();
        $nbLikes = $donnees['nbLikes']; // nb de likes émis par l'utilisateur courant

        $reponse = $bdd->query('SELECT id AS idUser FROM IMAC_Utilisateur WHERE pseudo= "'.$_SESSION['pseudo'].'"');
        $donnees = $reponse->fetch();
        $reponse->closeCursor();
        $idUser = $donnees['idUser'];

        if($nbLikes == 0){ // Un utilisateur ne peut pas ajouter plus de 1 like sur une même publication
            $reponse = $bdd->query('INSERT INTO IMAC_AimerPublication(id, id_IMAC_Utilisateur) VALUES('.$id.', "'.$idUser.'" )'); //requête marche
            header ('location: publication.php?id='.$id.'');
        }

        else{ // Retirer le like
            $reponse = $bdd->query('UPDATE IMAC_AimerPublication SET  WHERE id = ' . $id . ''); // A REPARER
            header("location:".  $_SERVER['HTTP_REFERER']);
        }
};

?> 