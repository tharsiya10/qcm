<?php 
require_once('fonction.php');

function qcm_answered($idUser, $idYr){
	$bdd = database();
	$req = $bdd->query("SELECT * FROM QCM_answered WHERE idUser = $idUser && idYr = $idYr");
	$val = $req->fetch();
	return $val;
}

function reponse_answered($idUser, $idYr, $idQuest){
	$bdd = database();
	$reqexist = $bdd->query("SELECT * FROM QCM_answered WHERE idUser = $idUser && idYr = $idYr && idQuest = $idQuest");
	$valexist = $reqexist->rowCount();
	$val = " ";
	if($valexist != 0){
		$req = $bdd->query("SELECT * FROM QCM_answered WHERE idUser = $idUser && idYr = $idYr && idQuest = $idQuest");
		$tmp = $req->fetch();
		$val = $tmp['rep'];
	}
	return $val;
}

function insert_qcm_answered($idYr, $idQuest, $idUser, $rep){
	$bdd = database();

	//Insertion et update dans qcm_answered

	$req_exist = $bdd->prepare("SELECT * FROM QCM_answered WHERE idQuest = ? AND idUser = ? AND idYr = ?");
	$req_exist->execute(array($idQuest,$idUser,$idYr));
	$exist = $req_exist->rowCount();

	if($exist == 0) {
		// $req = $bdd->query("INSERT INTO QCM_answered(idYr,idQuest,idUser,rep,correct) VALUES($idYr,$idQuest,$idUser,$rep,0)");
		$req = $bdd->prepare("INSERT INTO QCM_answered(idYr,idQuest,idUser,rep,correct) VALUES(?,?,?,?,?)");
		$req->execute(array($idYr, $idQuest, $idUser, $rep, 0));

	}
	elseif($exist == 1) {
		$req = $bdd->prepare("UPDATE QCM_answered SET rep = ? WHERE idQuest = ? AND idUser = ? AND idYr = ?");
		$req->execute(array($rep,$idQuest,$idUser,$idYr));
	}
	// print_r($rep);
}

function insert_poeme_answered($idYr, $idPoeme, $idUser, $rep1, $rep2, $rep3, $rep4, $rep5){
	$bdd = database();

	//Insertion et update dans qcm_answered

	$req_exist = $bdd->prepare("SELECT * FROM poeme_answered WHERE idYr = ? AND idPoeme = ? AND idUser = ?");
	$req_exist->execute(array($idYr,$idPoeme,$idUser));
	$exist = $req_exist->rowCount();

	if($exist == 0) {
		$req = $bdd->prepare("INSERT INTO poeme_answered(idYr,idPoeme,idUser,rep1,rep2,rep3,rep4,rep5,correct) VALUES(?,?,?,?,?,?,?,?,?)");
		$req->execute(array($idYr,$idPoeme,$idUser,$rep1,$rep2,$rep3,$rep4,$rep5,0));

	}
	if($exist == 1) {
		$req = $bdd->prepare("UPDATE poeme_answered SET rep1 = ?, rep2 = ?, rep3 = ?, rep4 = ?, rep5 = ? WHERE idUser = ? AND idYr = ? AND idPoeme = ?");
		$req->execute(array($rep1,$rep2,$rep3,$rep4,$rep5,$idUser,$idYr,$idPoeme));
		
	}
}

function insert_texte_answered($idYr, $idTexte, $idUser, $rep1, $rep2, $rep3, $rep4, $rep5){
	$bdd = database();

	//Insertion et update dans qcm_answered

	$req_exist = $bdd->prepare("SELECT * FROM texte_answered WHERE idYr = ? AND idTexte = ? AND idUser = ?");
	$req_exist->execute(array($idYr,$idTexte,$idUser));
	$exist = $req_exist->rowCount();

	if($exist == 0) {
		$req = $bdd->prepare("INSERT INTO texte_answered(idYr,idTexte,idUser,rep1,rep2,rep3,rep4,rep5,correct) VALUES(?,?,?,?,?,?,?,?,?)");
		$req->execute(array($idYr,$idTexte,$idUser,$rep1,$rep2,$rep3,$rep4,$rep5,0));

	}
	if($exist == 1) {
		$req = $bdd->prepare("UPDATE texte_answered SET rep1 = ?, rep2 = ?, rep3 = ?, rep4 = ?, rep5 = ? WHERE idUser = ? AND idYr = ? AND idTexte = ?");
		$req->execute(array($rep1,$rep2,$rep3,$rep4,$rep5,$idUser,$idYr,$idTexte));
		
	}
}
?>