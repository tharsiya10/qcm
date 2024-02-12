<?php 
require_once('fonction.php');

function getUserDetails($idUser){
	$bdd = database();
	$req = $bdd->query("SELECT * FROM users WHERE idUser = $idUser");
	$val = $req->fetch();
	return $val;
}

function getStudentsByNiv($niv){
	$bdd = database();
	$req = $bdd->query("SELECT * FROM users WHERE idUser != 1 && niv = $niv ORDER BY idUser ASC");
	$val = $req->fetch();
	return $val;
}


?>