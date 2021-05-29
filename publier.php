<?php
    session_start();
    include 'bdd.php';

    $reponse = $bdd->query('SELECT id FROM IMAC_Utilisateur WHERE pseudo="'.$_SESSION["pseudo"].'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    $id_utilisateur=$donnees['id'];

    $texte = htmlspecialchars($_POST['texte']);

    $reponse = $bdd->query('SELECT MAX(id) as nb_Publication FROM IMAC_Publication');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();

    $id_publication=$donnees['nb_Publication']+1;
    
    if(isset($_FILES["image"])){
        $repertoireDestination = dirname(__FILE__)."/publication/";
        $nomDestination        = $id_publication.".jpg";
        if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
            rename($_FILES["image"]["tmp_name"],
            $repertoireDestination.$nomDestination);
            chmod($repertoireDestination.$nomDestination, 0755);
        }
    }

    $reponse = $bdd->query('INSERT INTO IMAC_Publication(texte, image, date, id_IMAC_Utilisateur) values("'.$texte.'", "publication/'.$nomDestination.'", CURDATE(),"'.$id_utilisateur.'")');
    $reponse->closeCursor();

    header('location: profil.php?pseudo='.$_SESSION["pseudo"].'');
?>