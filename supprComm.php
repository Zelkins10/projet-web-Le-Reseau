<?php

include 'bdd.php';

$bdd->query('DELETE FROM IMAC_Commentaire WHERE idComm = ' . $idComm . '');

header("location:".  $_SERVER['HTTP_REFERER']);

?>