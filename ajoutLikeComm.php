<?php

session_start();
include 'bdd.php';
$pseudo = $_SESSION['pseudo'];

$idComm = $_GET['id'];

$reponse2 = $bdd->query('SELECT id_IMAC_Publication FROM IMAC_Commentaire WHERE IMAC_Commentaire.id = '. $idComm .'');
$donnees2 = $reponse2->fetch();
$reponse2->closeCursor();
$idPublication = $donnees2['id_IMAC_Publication'];


if(!isset($pseudo)){
    header('location: formConnexion.php');
}

else{
    include 'bdd.php';

    $reponse = $bdd->query('SELECT COUNT(*) AS nbLikesComm FROM IMAC_AimerCommentaire
    JOIN IMAC_Commentaire ON IMAC_AimerCommentaire.id = IMAC_Commentaire.id
    JOIN IMAC_Utilisateur ON IMAC_AimerCommentaire.id_IMAC_Utilisateur = IMAC_Utilisateur.id
    WHERE IMAC_Utilisateur.pseudo="'.$pseudo.'" AND IMAC_Commentaire.id='.$idComm.'');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    $nbLikesComm = $donnees['nbLikesComm']; // nb de likes émis par l'utilisateur courant

    if($nbLikesComm == 0){ // Un utilisateur ne peut pas ajouter plus de 1 like sur un même commentaire
        $reponse = $bdd->query('SELECT id AS idUser FROM IMAC_Utilisateur WHERE pseudo= "'.$pseudo.'"');
        $donnees = $reponse->fetch();
        $reponse->closeCursor();
        $idUser = $donnees['idUser'];

        $reponse = $bdd->query('INSERT INTO IMAC_AimerCommentaire(id, id_IMAC_Utilisateur) VALUES('.$idComm.', "'.$idUser.'" )');
    }

    else{ // Retirer le like
        $reponse = $bdd->query('SELECT id AS idUser FROM IMAC_Utilisateur WHERE pseudo= "'.$pseudo.'"');
        $donnees = $reponse->fetch();
        $reponse->closeCursor();
        $idUser = $donnees['idUser'];
        $reponse = $bdd->query('DELETE FROM IMAC_AimerCommentaire WHERE id = '.$idComm.' and id_IMAC_Utilisateur='.$idUser.'');
    }
    header('location: publication.php?id='.$idPublication.'');
}

?> 