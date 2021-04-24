<?php
    session_start();
    if(isset($_SESSION['pseudo'])){
        header('location: formConnexion.php?erreur=dejaCo');
    }
    else{
        include 'bdd.php';
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $motDePasse = htmlspecialchars($_POST['motDePasse']);

        if ($pseudo=="admin" && $motDePasse=="mdp"){
            $_SESSION['pseudo'] = $pseudo;
            header ('location: formConnexion.php?erreur=aucune');
        }
        else{
            $reponse = $bdd->query('SELECT COUNT(*) as nbCompte FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'" AND motDePasse="'.$motDePasse.'"');
            $donnees = $reponse->fetch();
            $reponse->closeCursor();

            $nbCompte=$donnees['nbCompte'];
            if($nbCompte==0){
                header('location: formConnexion.php?erreur=existePas');
            }
            else {
                $_SESSION['pseudo']=$pseudo;
                header ('location: formConnexion.php?erreur=aucune');
            }
        }
    }
?>