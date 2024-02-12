<?php 
require('fonction.php');

function getYear($niv,$idYr){
	$bdd = database();
	try {
		$req = $bdd->query("SELECT year FROM annee WHERE idYr =".$idYr." && niv = ".$niv);
		$val = $req->fetch(); 
		return $val;
	}
	catch(PDOException $e){
		print("Year not found");
	}

}

function getIdYr($year, $niv){
	$bdd = database();
	
	try {
		$req = $bdd->prepare("SELECT idYr FROM annee WHERE year = ? && niv = ?");
		$req->execute(array($year,$niv));
		$val = $req->fetch();
		return $val;
	}
	catch(PDOException $e){
		print("Erreur");
	} 
	

}

function getMode($idYr){
	$bdd = database();
	
	try {
		$req = $bdd->prepare("SELECT mode FROM annee WHERE idYr = ?");
		$req->execute(array($idYr));
		$val = $req->fetch();
		return $val;
	}
	catch(PDOException $e){
		print("Erreur");
	} 
}


function add_annee($niv, $year){
	$bdd = database();
	//Vérifier que titre n'est pas déjà dans la bdd
	$reqexist = $bdd->prepare("SELECT * FROM annee WHERE niv = ? && year = ?");
	$reqexist->execute(array($niv,$year));
	$valexist = $reqexist->rowCount();
	if($valexist == 0) {
		// print_r($valexist);
		$reqinsert = $bdd->prepare("INSERT INTO annee(niv,year) VALUES(?,?)");
		$reqinsert->execute(array($niv,$year));
		$req = $bdd->prepare("SELECT * FROM annee WHERE niv = ? && year = ?");
		$req->execute(array($niv,$year));
		$val = $req->fetch(); 
		// print_r($val);
		return $val; 
	}
	/* cas où le sujet existe déjà*/
	

}

?> 