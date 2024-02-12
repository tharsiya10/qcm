<?php
session_start();
require_once('menu.php');

if(isset($_SESSION['id'])&& $_SESSION['id'] == 1 && !empty($_GET['niv']) && !empty($_GET['idYr'])){
	$req1 = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
	$req1->execute(array($_GET['idYr']));
	$val1 = $req1->fetch();

	if(isset($_POST['next'])){
		$question = $_POST['question'];
		$bonnerep = $_POST['bonne'];
		$choix1 = $_POST['choix_1'];
		$choix2 = $_POST['choix_2'];
		$choix3 = $_POST['choix_3'];

		//Insertion de question
		

		$req2 = $bdd->prepare("INSERT INTO questions(idYr,quest,ans_id) VALUES(?,?,?)");
		$req2->execute(array($_GET['idYr'],$question,0));

		//Trouver idQuest
		$req3 = $bdd->prepare("SELECT * FROM questions WHERE idYr = ? AND quest = ?");
		$req3->execute(array($_GET['idYr'],$question));
		$val3 = $req3->fetch();

		//Insertion des réponses

		$req4 = $bdd->prepare("INSERT INTO reponses(idYr,idQuest,rep) VALUES(?,?,?)");
		$req4->execute(array($_GET['idYr'],$val3['idQuest'],$bonnerep));

		$req5 = $bdd->prepare("INSERT INTO reponses(idYr,idQuest,rep) VALUES(?,?,?)");
		$req5->execute(array($_GET['idYr'],$val3['idQuest'],$choix1));

		$req6 = $bdd->prepare("INSERT INTO reponses(idYr,idQuest,rep) VALUES(?,?,?)");
		$req6->execute(array($_GET['idYr'],$val3['idQuest'],$choix2));

		$req7 = $bdd->prepare("INSERT INTO reponses(idYr,idQuest,rep) VALUES(?,?,?)");
		$req7->execute(array($_GET['idYr'],$val3['idQuest'],$choix3));

		//Chercher idRep de la bonne reponse

		$req8 = $bdd->prepare("SELECT * FROM reponses WHERE idQuest = ? AND rep = ?");
		$req8->execute(array($val3['idQuest'],$bonnerep));
		$val8 = $req8->fetch();

		//update dans questions

		$req9 = $bdd->prepare("UPDATE questions SET ans_id = ? WHERE idQuest = ?");
		$req9->execute(array($val8['idRep'],$val3['idQuest']));

		


	}
	if(isset($_POST['finish'])){


		header("Location: pageQCM.php?id=1&niv=".$_GET['niv']."&idYr=".$_GET['idYr']);
		

	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Nouveau QCM</title>
	<meta charset="utf-8">

</head>
<body>
	<h1><?=$val1['year']?></h1>

	<form method="post">
		<label>Question :<input type="textarea" name="question"></label>
		<label>Bonne réponse :<input type="textarea" name="bonne"></label>
		<label>Choix :<input type="textarea" name="choix_1"></label>
		<label>Choix :<input type="textarea" name="choix_2"></label>
		<label>Choix :<input type="textarea" name="choix_3"></label>

		<input type="submit" name="next" value="Suivante">
		<input type="submit" name="finish" value="Terminer">
	</form>

</body>
</html>