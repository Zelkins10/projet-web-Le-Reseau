<?php
    session_start();
    $barre=$_POST['barre'];
    include 'bdd.php';
    include 'header.php';
?>

<a href="index.php"><h1>Le Réseau</h1></a>
<div class="centrerPage">
    <p>Les Utilisateurs correspondant à votre recherche :</p><br><br>
    <?php
        if(!empty($barre)){
        $reponse = $bdd->query('SELECT * FROM IMAC_Utilisateur WHERE pseudo LIKE "%'.$barre.'%" LIMIT 50');
        while ($donnees = $reponse->fetch()) { 
    ?>

    <a href="profil.php?pseudo=<?php echo $donnees['pseudo']; ?>" class="blanc">
        <?php 
            $filename='photoProfil/'.$donnees['id'].'.jpg';
            if(file_exists($filename)){
                echo "<img class='photo' src='".$donnees['photoProfil']."'>";
            }
            echo $donnees['pseudo'];
            echo "<br><br>";
        ?>
    </a>
    <?php 
    }
    $reponse->closeCursor();
    ?>

    <?php
        }
        else{
            echo '<div class="erreur">champ vide</div>'; //au cas où il tape dans l'url la page sans passer par le formulaire
        }
    ?>
</div>

</body>
</html>