<?php
	session_start();
	include 'bdd.php';
	include 'header.php';
    if(isset($_SESSION['pseudo'])){
        $pseudo=$_SESSION['pseudo'];
    }
?>
    <body>
        <div class="publication">
        <form method="post" action="publier.php" enctype="multipart/form-data">
            <input type="textarea" name="texte" placeholder="Veuillez écrire votre message" required><br>
            Image : <input type="file" name="image"><br>
            <input type="submit" value="Valider"/>
            <input type="reset" value="Annuler"/>
		</form>
        </div>
    </body>
</html>