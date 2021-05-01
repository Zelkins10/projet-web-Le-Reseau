<?php
	session_start();
	include 'bdd.php';
    if(isset($_SESSION['pseudo'])){
        $pseudo=$_SESSION['pseudo'];
    }
    $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo="'.$pseudo.'"');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();
    $id_utilisateur=$donnees['id'];
    $id_destinataire=$_GET['id'];
    
    $texte = htmlspecialchars($_POST['texte']);
    
    $reponse = $bdd->query('SELECT COUNT(*) as nb_Message FROM IMAC_MessagePrive');
    $donnees = $reponse->fetch();
    $reponse->closeCursor();

    $id_messagePrive=$donnees['nb_Message']+1;

    if(isset($_FILES["image"])){
        $repertoireDestination = dirname(__FILE__)."/messagePrive/";
        $nomDestination        = $id_messagePrive.".jpg";
        if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
            rename($_FILES["image"]["tmp_name"],
            $repertoireDestination.$nomDestination);
            chmod($repertoireDestination.$nomDestination, 0755);
        }
    }

    $reponse = $bdd->query('INSERT INTO IMAC_MessagePrive(image, date, texte, id_IMAC_Utilisateur, id_IMAC_Utilisateur_recevoir) values("messagePrive/'.$nomDestination.'", CURDATE(), "'.$texte.'", "'.$id_utilisateur.'", "'.$id_destinataire.'")');
    $reponse->closeCursor();

    header('location:'. $_SERVER['HTTP_REFERER']);
?>