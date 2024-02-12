<?php 
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=id21321017_tamoul','root','');
	}

	catch(PDOException $e){
		print "Erreur de connexion à la base de donnée : ".$e->getMessage();
		die();
	}
 ?>
