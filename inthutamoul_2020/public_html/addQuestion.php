<?php
session_start();
require_once('database.php');
require_once('fonction_annee.php');

if(isset($_SESSION['id'])&& $_SESSION['id'] == 1 && !empty($_GET['niv']) && !empty($_GET['idYr'])){
	// $req1 = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
	// $req1->execute(array($_GET['idYr']));
	// $val1 = $req1->fetch();
	$val1 = getYear($_GET['idYr'],$_GET['niv']);

	if(isset($_POST['next'])){
		$question = $_POST['question'];
		$choix1 = $_POST['choix1'];
		$choix2 = $_POST['choix2'];
		$choix3 = $_POST['choix3'];
		$choix4 = $_POST['choix4'];

		//Insertion de question

		$req2 = $bdd->prepare("INSERT INTO questions(idYr,quest,ans_id) VALUES(?,?,?)");
		$req2->execute(array($_GET['idYr'],$question,0));

		//Trouver idQuest
		$req3 = $bdd->prepare("SELECT * FROM questions WHERE idYr = ? AND quest = ?");
		$req3->execute(array($_GET['idYr'],$question));
		$val3 = $req3->fetch();

		for($i = 1; $i<5; $i++){
			if(isset($_POST['bonne'.$i])){
				$req4 = $bdd->prepare("INSERT INTO reponses(idYr,idQuest,rep) VALUES(?,?,?)");
				$req4->execute(array($_GET['idYr'],$val3['idQuest'],$_POST['choix'.$i]));	
				
				//Chercher idRep de la bonne reponse

				$req6 = $bdd->prepare("SELECT * FROM reponses WHERE idQuest = ? AND rep = ?");
				$req6->execute(array($val3['idQuest'],$_POST['choix'.$i]));
				$val6 = $req6->fetch();

				//update dans questions

				$req7 = $bdd->prepare("UPDATE questions SET ans_id = ? WHERE idQuest = ?");
				$req7->execute(array($val6['idRep'],$val3['idQuest']));
			}

			else {
				$req5 = $bdd->prepare("INSERT INTO reponses(idYr,idQuest,rep) VALUES(?,?,?)");
				$req5->execute(array($_GET['idYr'],$val3['idQuest'],$_POST['choix'.$i]));
			}
		}

		


	}
	if(isset($_POST['back'])){

		header('Location:pageQCM.php?id=1&niv='.$_GET['niv'].'&idYr='.$_GET['idYr']);
		

	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Nouveau QCM</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="addquestion.css" /> 
</head>
<body>
	<a class="back" style="text-decoration:none" href="pageQCM.php?id=1&niv=<?=$_GET['niv']?>&idYr=<?=$_GET['idYr']?>">Retour</a>
	<h1>Nouvelle question</h1>
	<br/>

	<div class="form-popup" id="myForm">
	<form method="post" class="form-container">
		<label>Question : <textarea id="question" name="question"></textarea></label>
		<table>
			<tr>
				<th>Choix</th>
				<th>Bonne réponse ?</th>
			</tr>
			<tr>
				<td><textarea id="choix1" name="choix1"></textarea></td>
				<td><input type="checkbox" name="bonne1"></td>

			</tr>
			<tr>
				<td><textarea id="choix2" name="choix2"></textarea></td>
				<td><input type="checkbox" name="bonne2"></td>

			</tr>
			<tr>
				<td><textarea id="choix3" name="choix3"></textarea></td>
				<td><input type="checkbox" name="bonne3"></td>

			</tr>
			<tr>
				<td><textarea id="choix4" name="choix4"></textarea></td>
				<td><input type="checkbox" name="bonne4"></td>

			</tr>
			
		</table>
		<br/><br/>
		<input type="submit" class= "btn" id="next" name="next" value="Suivante ">
		
	</form>

</body>
</html>