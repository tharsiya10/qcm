<?php
require_once('fonction.php');

function transfert_correction($idUser,$idYr,$nom){
	$bdd = database();
	$req_exist = $bdd->query("SELECT * FROM correction WHERE idYr = $idYr && idUser = $idUser");
	$exist = $req_exist->rowCount();
	if($exist == 0){
		$req = $bdd->query("INSERT INTO correction(idUser,idYr,nom_fichier,note) VALUES ($idUser,$idYr,$nom,O)");
	}
	else {
		$req = $bdd->query("UPDATE correction SET nom_fichier = $nom WHERE idYr = $idYr && idUser = $idUser");
	}
}

function correction_file($idYr, $idUser){
	$bdd = database();
	$req_exist = $bdd->query("SELECT * FROM correction WHERE idYr = $idYr && idUser = $idUser");
	$exist = $req_exist->rowCount();
	$val;
	if($exist != 0){
		$req = $bdd->query("SELECT * FROM correction WHERE idYr = $idYr && idUser = $idUser");
		$val = $req->fetch();
		return $val;
	}
}

function final_grade($idYr, $idUser, $note){
	$bdd = database();
	$req = $bdd->query("UPDATE correction SET note = $note WHERE idYr = $idYr && idUser = $idUser");
	
}

function get_final_grade($idYr, $idUser){
	$bdd = database();
	$req_exist = $bdd->prepare("SELECT note FROM correction WHERE idYr = ? && idUser = ?");
	$req_exist->execute(array($idYr,$idUser));
	$exist = $req_exist->rowCount();
	$val;
	if($exist != 0){
		$req = $bdd->prepare("SELECT note FROM correction WHERE idYr = ? && idUser = ?");
		$req->execute(array($idYr,$idUser));
		$val = $req->fetch();
		return $val;
	}
	
}
?>