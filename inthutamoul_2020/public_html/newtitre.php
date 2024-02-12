<?php
session_start();
require_once('menu.php');

if($_SESSION['id'] == 1) {
	if(isset($_POST['titre']) && !empty($_GET['niv'])){
		$titre = htmlentities($_POST['titre']);
		$niv = $_GET['niv'];
		if(isset($_POST['submit'])) {
			//Vérifier que titre n'est pas déjà dans la bdd
			$req1 = $bdd->prepare("SELECT * FROM annee WHERE year = ? && niv = ?");
			$req1->execute(array($titre,$niv));
			$val1 = $req1->rowCount();
			if($val1 == 0) {
				$req2 = $bdd->prepare("INSERT INTO annee(niv,year) VALUES(?,?)");
				$req2->execute(array($niv,$titre));

				$req3 = $bdd->prepare("SELECT * FROM annee WHERE niv = ? && year = ?");
				$req3->execute(array($niv,$titre));
				$val3 = $req3->fetch();  
				header('Location: addQuestion.php?id=1&niv='.$_GET['niv'].'&idYr='.$val3['idYr']);
			}

			else {
				$erreur = "Ce sujet existe déjà";
			}
		}
	}


}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Créer un sujet</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="form.css">
</head>
<body>
	<h1>Créer un sujet</h1>

	<form method="post">
		<!-- <SELECT name="niv">
			<OPTION value="5">Valarnilai 5</OPTION>
			<OPTION value="6">Valarnilai 6</OPTION>
			<OPTION value="7">Valarnilai 7</OPTION>
		</SELECT> -->
		<label>Titre : <input type="text" name="titre" autofocus></label> <br/> <br/><br/>
		<input type="submit" id="finish" name="submit" value="Valider">
	</form>

	<?php 
		if(isset($erreur)){
			echo '<font color="red">'.$erreur.'</font>';
		}
	?>

</body>
</html>