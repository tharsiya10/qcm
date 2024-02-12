<?php 
session_start();
require_once('database.php');
require_once('fonction.php');
require_once('fonction_qcm_answered.php');


$con = mysqli_connect('localhost','root','','id21321017_tamoul');
$id = $_SESSION['id'];
$req = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
$req->execute(array($_GET['idYr']));
$donnee = $req->fetch();


?>

<!DOCTYPE html>
<html>
<head>
	<title>QCM</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="qcm.css" /> 
</head>
<body>
	
	<a class="back" style="text-decoration:none" href="annee.php?id=<?=$id?>&niv=<?=$_GET['niv']?>">Retour</a>
	<h1>QCM <?=$donnee['year']?></h1>
	
	<form method="post" action="relecture.php?id=<?=$id?>&niv=<?=$_GET['niv']?>&idYr=<?=$_GET['idYr']?>">
	<?php

	$idYr = $_GET['idYr'];
	
		$query = "select * from questions where idYr = $idYr";
		$result = mysqli_query($con, $query);
		$i = 1;
		$rep_answered;
		if($_SESSION['id'] != 1){
			$reqexist = $bdd->prepare("SELECT * FROM QCM_answered WHERE idUser = ? && idYr = ?");
			$reqexist->execute(array($_SESSION['id'],$_GET['idYr']));
			$valexist = $reqexist->rowCount();
			$info = $reqexist->fetch();
			
			if($valexist == 1){
				
				$req = $bdd->prepare("DELETE FROM QCM_answered WHERE idUser = ? && idYr = ?");
				$req->execute(array($_SESSION['id'],$_GET['idYr']));
				
						
			}
			
			

		}

		while($rows = mysqli_fetch_array($result)){
			$rows_idQuest = $rows['idQuest'];
			?>

			<div class="question">
				<?php echo "<strong>".$i.". ".$rows['quest']."</strong>";  ?>
				<?php 
				$i++;
				if($_SESSION['id'] == 1){
			?>
			<a href="editQuestion.php?id=1&niv=<?=$_GET['niv']?>&idYr=<?=$idYr?>&idQuest=<?=$rows_idQuest?>">Modifier question</a> - <a href="delQuestion.php?id=1&niv=<?=$_GET['niv']?>&idYr=<?=$idYr?>&idQuest=<?=$rows_idQuest?>">Supprimer question</a>
			<?php } ?>
			</div> 
			

			<br/>

			<?php 
			$idQuest = $rows['idQuest'];
			$querybis = "select * from reponses where idQuest = $idQuest";
			$resultbis = mysqli_query($con,$querybis);
			
			while($rowsbis = mysqli_fetch_array($resultbis)){
				$req = $bdd->prepare("SELECT * FROM QCM_answered WHERE idUser = ? && idYr = ? && idQuest = ?");
				$req->execute(array($_SESSION['id'],$_GET['idYr'],$idQuest));
				$exist = $req->rowCount();
				$rep_answered = $req->fetch();
					
				

			?>
		
			
				<?php 
				if($_SESSION['id'] != 1) {
					
					?>
					<label class="container">
						<input type="radio" 
						name="ans[<?php echo $rowsbis['idQuest'];?>]" 
						value="<?php echo $rowsbis['idRep']; ?>" <?php if($exist == 1 && $rep_answered['rep'] == $rowsbis['rep']) {?> checked <?php }?>><span class="underline"><?=$rowsbis['rep']?>&ensp;</span>
						
					
					
					</label>

					
				<?php
				} 
				if($_SESSION['id'] == 1) { 

					?>
					<p><?=$rowsbis['rep']?>

					<?php 
					if($rowsbis['idRep'] == $rows['ans_id']){ echo '<font color="green"> ✔ </font>';
						
					}
					?> </p>
					

		<?php } 

		 	 }?>  
		 	<br/><br/><hr><br/><?php 
			} 
		
	// } 
		

		if($_SESSION['id'] != 1){
			
		?>


		<div style="text-align:center">
			<input type="submit" name="submit" value="Valider">
		</div>
	<?php } ?>

	</form>
	
	<?php if($_SESSION['id'] == 1) {
	?>
	
	<button class="open-new-question" onclick="window.location.href='addQuestion.php?id=1&niv=<?=$_GET['niv']?>&idYr=<?=$_GET['idYr']?>'">+ Ajouter question</button>


	<?php
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

	<div class="form-popup" id="myForm">
		
	</div>
	<br/>

<?php } ?>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>
<?php


?> 
	
</body>
</html>
	