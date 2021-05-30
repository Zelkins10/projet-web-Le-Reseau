<?php
	session_start();
	include 'bdd.php';

    $nbEmail=0;
    $nbPseudo=0;
    $email = htmlspecialchars($_POST['email']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $motDePasseActuel = htmlspecialchars($_POST['motDePasseActuel']);
    if($_POST['nouveauMotDePasse']!=NULL){
        $nouveauMotDePasse=htmlspecialchars($_POST['nouveauMotDePasse']);
    }
    $bio = htmlspecialchars($_POST['bio']);

    $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$_SESSION['pseudo'].'"');
    $donnees = $reponse->fetch();
    if($motDePasseActuel!=$donnees['motDePasse']){
        header('location: formParametres.php?erreur=mdp');
    }
    if($email!=$donnees['email']){
        $reponse2 = $bdd->query('SELECT COUNT(*) as nbEmail FROM IMAC_Utilisateur WHERE email="'.$email.'"');
        $donnees2 = $reponse2->fetch();
        $reponse2->closeCursor();
    
        $nbEmail=$donnees2['nbEmail'];
    }
    if($pseudo!=$donnees['pseudo']){
        $reponse3 = $bdd->query('SELECT COUNT(*) as nbPseudo FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
        $donnees3 = $reponse3->fetch();
        $reponse3->closeCursor();

        $nbPseudo=$donnees3['nbPseudo'];
    }
    $reponse->closeCursor();

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
        $id=$donnees['id'];
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
        if(isset($nouveauMotDePasse)){
            $reponse = $bdd->query('UPDATE IMAC_Utilisateur
                                SET pseudo = "'.$pseudo.'",
                                    email = "'.$email.'",
                                    motDePasse = "'.$nouveauMotDePasse.'",
                                    bio = "'.$bio.'",
                                    photoProfil="photoProfil/'.$nomDestination.'"
                                WHERE pseudo = "'.$_SESSION['pseudo'].'"');
            $reponse->closeCursor();
        }
        else{
            $reponse = $bdd->query('UPDATE IMAC_Utilisateur
                                SET pseudo = "'.$pseudo.'",
                                    email = "'.$email.'",
                                    motDePasse = "'.$motDePasseActuel.'",
                                    bio = "'.$bio.'",
                                    photoProfil="photoProfil/'.$nomDestination.'"
                                WHERE pseudo = "'.$_SESSION['pseudo'].'"');
        }
        
        $reponse->closeCursor();
        $_SESSION['pseudo']=$pseudo;
        header ('location: formParametres.php?erreur=aucune');
    }
?>