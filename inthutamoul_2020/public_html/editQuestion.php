<?php
session_start();
require_once('database.php');
require('fonction.php');
require_once('menu.php');

if(isset($_SESSION['id']) && $_SESSION['id'] == 1 && !empty($_GET['niv']) && !empty($_GET['idYr']) && !empty($_GET['idQuest'])){
	
	$con = mysqli_connect('localhost','root','','id21321017_tamoul');
	$req1 = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
	
	$req1->execute(array($_GET['idYr']));
	$val1 = $req1->fetch();
	$idQuest = $_GET['idQuest'];

	if(isset($_POST['finish'])) {
		
		if(!empty($_POST['question']) && !empty($_POST['ans']) && !empty($_POST['bonne'])){
			$question = $_POST['question'];
			$ans = $_POST['ans'];
			$bonne = $_POST['bonne'];


			//Update la question
			$req2 = $bdd->prepare("UPDATE questions SET quest = ? WHERE idQuest = ?");
			$req2->execute(array($question,$_GET['idQuest']));

			//Update reponses et ans_id dans questions
			

			foreach ($ans as $key => $value) {
				$req3 = $bdd->prepare("UPDATE reponses SET rep = ? WHERE idQuest = ? AND idRep = ?");
				$req3->execute(array($value,$idQuest,$key));

				if($bonne[$idQuest] == $key){
					$req4 = $bdd->prepare("UPDATE questions SET ans_id = ? WHERE idQuest = ?");
					$req4->execute(array($key,$idQuest));
				}
			}

			header("Location: pageQCM.php?id=1&niv=".$_GET['niv']."&idYr=".$_GET['idYr']);


		}

	
	}


}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifier question</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="addquestion.css">
</head>
<body>


	<h1><?=$val1['year']?></h1>
<div class="form-popup">
	<form method="post" class="form-container">

		<?php

		

		$query = "select * from questions where idQuest = $idQuest";
		$result = mysqli_query($con, $query);

		while($rows = mysqli_fetch_array($result)){
		?>


		<label>Question : <input type="textarea" name="question" value="<?=$rows['quest']?>"></label>
		<table>
			<tr>
				<th>Choix</th>
				<th>Bonne réponse </th>
			</tr>

			<?php 
			// $idQuest = $rows['idQuest'];
			$querybis = "select * from reponses where idQuest = $idQuest";
			$resultbis = mysqli_query($con,$querybis);
			// $i = 0;
			while($rowsbis = mysqli_fetch_array($resultbis)){
				
			?>
			
			<tr>

				<td><input type="textarea" name="ans[<?php echo $rowsbis['idRep']; ?>]" value="<?php echo $rowsbis['rep'];?>"></td>
				<td><input type="checkbox" name="bonne[<?php echo $rowsbis['idQuest']; ?>]"value="<?php echo $rowsbis['idRep'];?>"<?php if($rowsbis['idRep'] == $rows['ans_id']) {?> checked <?php } ?>></td>


			</tr>
			<?php 
			// $i ++; 
			} 
		}?>
		</table>
		<br/>
		<input type="submit" id="finish" name="finish" value="Modifier">
	</form>
</div>
</body>
</html>
