<?php
	session_start();
	include 'bdd.php';
    if(isset($_SESSION['pseudo'])){
        $pseudo=$_SESSION['pseudo'];
    }else{
        header('location: formConnexion.php');
    }

    $reponse = $bdd->query('SELECT id FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    $id_utilisateur=$donnees['id'];
    $id_suivre=$_GET['id'];
    
    header('location:'. $_SERVER['HTTP_REFERER']);
    
    $reponse = $bdd->query('SELECT COUNT(*) as nbFollow FROM IMAC_Suivre WHERE id='.$id_utilisateur.' and id_IMAC_Utilisateur='.$id_suivre.'');
    $donnees = $reponse->fetch();
    $nbFollow = $donnees['nbFollow'];
    $reponse->closeCursor();
    if($nbFollow==0){
        $reponse = $bdd->query('INSERT INTO IMAC_Suivre(id, id_IMAC_Utilisateur) values("'.$id_utilisateur.'", "'.$id_suivre.'")');
        $reponse->closeCursor();
    }
    else{
        $reponse = $bdd->query('DELETE FROM IMAC_Suivre WHERE id='.$id_utilisateur.' and id_IMAC_Utilisateur='.$id_suivre.'');
        $reponse->closeCursor();
    }
?>