<?php

$idComm=$_GET['id'];

include 'bdd.php';

$bdd->query('DELETE FROM IMAC_AimerCommentaire WHERE id = ' . $idComm . '');
$bdd->query('DELETE FROM IMAC_Commentaire WHERE id = ' . $idComm . '');

header("location:".  $_SERVER['HTTP_REFERER']);

?>