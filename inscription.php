<?php
    $email = htmlspecialchars($_POST['email']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $motDePasse = htmlspecialchars($_POST['motDePasse']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $bio = htmlspecialchars($_POST['bio']);

    if(isset($_FILES["photoProfil"])){
        $repertoireDestination = dirname(__FILE__)."/photoProfil/";
        $nomDestination        = $pseudo.".jpg";
        if (is_uploaded_file($_FILES["photoProfil"]["tmp_name"])) {
            rename($_FILES["photoProfil"]["tmp_name"],
            $repertoireDestination.$nomDestination);
        }
    }
    include 'bdd.php';
    $reponse = $bdd->query('INSERT INTO IMAC_Utilisateur(pseudo, MotDePasse, prenom, nom, email, bio, photoProfil) values("'.$pseudo.'", "'.$motDePasse.'", "'.$prenom.'", "'.$nom.'", "'.$email.'", "'.$bio.'", "photoProfil/'.$nomDestination.'")');
    $reponse->closeCursor();
    header ('location: form.php');
?>