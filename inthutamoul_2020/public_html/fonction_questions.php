<?php
require_once('fonction.php');

//Why is it here ????
function new_question($idYr,$quest,$ans_id){
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM questions WHERE idQuest = ?");
	$req->execute(array($idQuest));
	$val = $req->fetch();
	return $val;
}

function getQuestions($idQuest){
	$bdd = database();
	$req = $bdd->prepare("SELECT quest FROM questions WHERE idQuest = ?");
	$req->execute(array($idQuest));
	$val = $req->fetch();
	return $val;
}

function getAnsId($idQuest){
	$bdd = database();
	$req = $bdd->prepare("SELECT ans_id FROM questions WHERE idQuest = ?");
	$req->execute(array($idQuest));
	$val = $req->fetch();
	return $val;
}
?>