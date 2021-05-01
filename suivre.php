<?php
	session_start();
	include 'bdd.php';
    if(isset($_SESSION['pseudo'])){
        $pseudo=$_SESSION['pseudo'];
    }
    $reponse = $bdd->query('SELECT id FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    $id_utilisateur=$donnees['id'];
    $id_suivre=$_GET['id'];
    $reponse = $bdd->query('INSERT INTO IMAC_Suivre(id, id_IMAC_Utilisateur) values("'.$id_utilisateur.'", "'.$id_suivre.'")');
    $reponse->closeCursor();
    header('location:'. $_SERVER['HTTP_REFERER']);
?>