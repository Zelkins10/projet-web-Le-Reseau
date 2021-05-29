<?php
	session_start();
	include 'bdd.php';

    $email = htmlspecialchars($_POST['email']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $motDePasse = htmlspecialchars($_POST['motDePasse']);
    $bio = htmlspecialchars($_POST['bio']);

    $reponse = $bdd->query('SELECT COUNT(*) as nbPseudo FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();

    $nbPseudo=$donnees['nbPseudo'];

    $reponse = $bdd->query('SELECT COUNT(*) as nbEmail FROM IMAC_Utilisateur WHERE email="'.$email.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();

    $nbEmail=$donnees['nbEmail'];

    if($nbPseudo>0 && $nbEmail>0){
        header('location: formParametres.php?erreur=pseudoETemail');
    }
    else if($nbPseudo>0){
        header('location: formParametres.php?erreur=pseudo');
    }
    else if($nbEmail>0){
        header('location: formParametres.php?erreur=email');
    }
    else {
        
        $reponse = $bdd->query('SELECT id FROM IMAC_Utilisateur WHERE pseudo="'.$_SESSION['pseudo'].'"');
        $donnees = $reponse->fetch();
        $id=$donnees['id']+1;
        $reponse->closeCursor();

        if(isset($_FILES["photoProfil"])){
            $repertoireDestination = dirname(__FILE__)."/photoProfil/";
            $nomDestination        = $id.".jpg";
            if (is_uploaded_file($_FILES["photoProfil"]["tmp_name"])) {
                rename($_FILES["photoProfil"]["tmp_name"],
                $repertoireDestination.$nomDestination);
                chmod($repertoireDestination.$nomDestination, 0755);
            }
        }
        $reponse = $bdd->query('UPDATE IMAC_Utilisateur
                                SET pseudo = "'.$pseudo.'",
                                    email = "'.$email.'",
                                    motDePasse = "'.$motDePasse.'",
                                    bio = "'.$bio.'",
                                    photoProfil="photoProfil/'.$nomDestination.'"
                                WHERE pseudo = "'.$_SESSION['pseudo'].'"');
        $reponse->closeCursor();
        $_SESSION['pseudo']=$pseudo;
        header ('location: formParametres.php?erreur=aucune');
    }
?>