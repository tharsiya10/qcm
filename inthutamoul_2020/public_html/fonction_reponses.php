<?php 
require_once('fonction.php');

function getReponses($idRep){
	$bdd = database();
	try {
		$req = $bdd->prepare("SELECT * FROM reponses WHERE idRep = ?");
		$req->execute(array($idRep));
		$val = $req->fetch();
		return $val;	
	}
	catch(PDOException $e){
		print("Erreur");
	}

}
?>