<?php
    session_start();
    if(isset($_SESSION['pseudo'])){
        header('location: form.php?erreur=dejaCo');
    }
    include 'bdd.php';
    $email = htmlspecialchars($_POST['email']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $motDePasse = htmlspecialchars($_POST['motDePasse']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
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
        header('location: form.php?erreur=pseudoETemail');
    }
    else if($nbPseudo>0){
        header('location: form.php?erreur=pseudo');
    }
    else if($nbEmail>0){
        header('location: form.php?erreur=email');
    }
    else {
        if(isset($_FILES["photoProfil"])){
            $repertoireDestination = dirname(__FILE__)."/photoProfil/";
            $nomDestination        = $pseudo.".jpg";
            if (is_uploaded_file($_FILES["photoProfil"]["tmp_name"])) {
                rename($_FILES["photoProfil"]["tmp_name"],
                $repertoireDestination.$nomDestination);
            }
        }
        $reponse = $bdd->query('INSERT INTO IMAC_Utilisateur(pseudo, MotDePasse, prenom, nom, email, bio, photoProfil) values("'.$pseudo.'", "'.$motDePasse.'", "'.$prenom.'", "'.$nom.'", "'.$email.'", "'.$bio.'", "photoProfil/'.$nomDestination.'")');
        $reponse->closeCursor();
        $_SESSION['pseudo']=$pseudo;
        header ('location: form.php');
    }
?>