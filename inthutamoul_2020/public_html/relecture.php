<?php
session_start();
require_once('database.php');
require_once('fonction_style.php');
require_once('fonction_qcm_answered.php');
require_once('fonction_questions.php');
require_once('fonction_reponses.php');
require_once('fonction_correction.php');
echo '<style>
h1,h2{
	text-align:center;
}

</style>';
echo '<link rel="stylesheet" type="text/css" href="correction.css">';
navigation_style();
navigation($_SESSION['id'],$_GET['niv']);
if($_SESSION['id'] != 1){

}
echo'<h1>Relecture</h1>';

$con = mysqli_connect('localhost','root','','id21321017_tamoul');
$id = $_SESSION['id'];
$req = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
$req->execute(array($_GET['idYr']));
$donnee = $req->fetch();

if($_SESSION['id'] != 1) {
	if(isset($_POST['submit'])) {
	

		$val_bareme = note($_SESSION['id'],$_GET['idYr']);
		
		$selected = $_POST['ans'];
		
		$idYr = $_GET['idYr'];

		$query = "select * from questions where idYr = $idYr";
		$result = mysqli_query($con, $query);

		$correct = array();
		
		$note = 0;


		while($rows = mysqli_fetch_array($result)){
			$correct[$rows['idQuest']] = $rows['ans_id'];

		}

		foreach ($selected as $key => $value) {
			$q = "select * from reponses where idQuest = $key && idRep = $selected[$key]";
			$r = mysqli_query($con,$q);
			$row = mysqli_fetch_array($r);

			$qbis = "select * from questions where idQuest = $key";
			$rbis = mysqli_query($con,$qbis);
			$rowbis = mysqli_fetch_array($rbis);

			$ans_id = $rowbis['ans_id'];
			$qter = "select * from reponses where idQuest = $key && idRep = $ans_id";
			$rter = mysqli_query($con,$qter);
			$rowter = mysqli_fetch_array($rter);

			$ans_user = $selected[$key];
			$qtetra = "select * from reponses where idQuest = $key && idRep = $ans_user";
			$rtetra = mysqli_query($con,$query);
			$rowtetra = mysqli_fetch_array($rtetra);

			$idQuest = $row['idQuest'];

			//Insertion et update dans qcm_answered

			insert_qcm_answered($rowbis['idYr'],$row['idQuest'],$_SESSION['id'],$row['rep']);
	


							if($selected[$key] == $correct[$key]) {
								$note ++;
				
								$reqbis = $bdd->prepare("UPDATE QCM_answered SET correct = 1 WHERE idQuest = ? AND idUser = ?");
								$reqbis->execute(array($idQuest,$_SESSION['id']));

								
							}


							else {
				
								$reqbis = $bdd->prepare("UPDATE QCM_answered SET correct = 0 WHERE idQuest = ? AND idUser = ?");
								$reqbis->execute(array($idQuest, $_SESSION['id']));

							
							}
			
						

			} 
		
		
		

		//Insérer notes


		insert_grade($_SESSION['id'],$_GET['idYr'],$note);

	}
}




if($_SESSION['id'] == 1){
	$i = 1;
	$req = $bdd->prepare("SELECT * FROM users WHERE idUser = ?");
	$req->execute(array($_GET['idUser']));
	$info = $req->fetch();
	$reqbis = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
	$reqbis->execute(array($_GET['idYr']));
	$infobis = $reqbis->fetch();
	echo '<h2>'.$info['prenom'].' '.$info['nom'].' '.$infobis['year'].'</h2>';

	$req1 = $bdd->prepare("SELECT * FROM QCM_answered WHERE idUser = ? && idYr = ?");
	$req1->execute(array($_GET['idUser'],$_GET['idYr']));

	?>

				<table>
			<thead>
				<tr>
					<th></th>
					<th>Question</th>
					<th>Réponse sélectionnée</th>
					<th></th>
					<th>Réponse correcte</th>
				</tr>
			</thead>
			<?php

	while($val1 = $req1->fetch()){

		$val2 = questions($val1['idQuest']);
		$val3 = reponses($val1['idQuest'],$val2['ans_id']);
		
		$val_reponse = reponse_answered($_GET['idUser'],$_GET['idYr'],$val2['idQuest']);
		
		
		?>
		<tbody>
				<tr>
					<td><?=$i?></td>
					<td><?=$val2['quest']?></td>
					<td><?=$val_reponse?></td>
					<td>
						<?php 
							if($val3) {
								if(!is_null($val3['rep'])) {
									if($val_reponse == $val3['rep']) {
										echo '<font color="green"> ✔ </font>';
									}
									else {
										echo '<font color="red"><strong>x</strong></font>';
									}
							
								}
	
								
							}
							
			
						?>
					</td>
					<td><?php
					if($val3) {
						if(!is_null($val3['rep'])) {
							echo $val3['rep'];
						}
					}
					
					else {
						echo ' ';
					}?></td>
				</tr>

				<?php
				$i++;
	}
	?>

		</tbody>
	<tfoot>
				<tr>
					<th></th>
					<th>Note</th>
					<td><strong>
						<?php
							
							$val_note = note($_GET['idUser'],$_GET['idYr']);
							$val_bareme = bareme($_GET['idYr']);
							echo $val_note['note'].'/'.$val_bareme;
						?></strong></td>
					<td></td>
					<td></td>
				</tr>
	</tfoot>
</table>
<br/><br/><br/>


	<?php


}

else {
	$i = 1;
	$req = $bdd->prepare("SELECT * FROM users WHERE idUser = ?");
	$req->execute(array($_SESSION['id']));
	$info = $req->fetch();
	$reqbis = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
	$reqbis->execute(array($_GET['idYr']));
	$infobis = $reqbis->fetch();
	echo '<h2>'.$info['prenom'].' '.$info['nom'].' '.$infobis['year'].'</h2>';


	$req1 = $bdd->prepare("SELECT * FROM QCM_answered WHERE idUser = ? && idYr = ?");
	$req1->execute(array($_SESSION['id'],$_GET['idYr'])); ?>

			<table>
			<thead>
				<tr>
					<th></th>
					<th>Question</th>
					<th>Réponse sélectionnée</th>
					<th></th>
					<th>Réponse correcte</th>
				</tr>
			</thead>

			<?php

	while($val1 = $req1->fetch()){
		
		$val2 = getQuestions($val1['idQuest']);
		$val_ans_id = getAnsId($val1['idQuest']);
		$val3 = getReponses($val_ans_id['ans_id']);
		?>

		<tbody>
				<tr>
					<td><?=$i?></td>
					<td><?=$val2['quest']?></td>
					<td><?=$val1['rep']?></td>
					<td>
						<?php 
							if($val1['rep'] == $val3['rep']) {
								

								echo '<font color="green"> ✔ </font>';
							}


							else {
				
								echo '<font color="red"><strong>x</strong></font>';
							}
			
						?>
					</td>
					<td><?=$val3['rep']?></td>
				</tr>

		<?php
		$i ++;
	}
	?>
	</tbody>
	<tfoot>
		<tr>
					<th></th>
					<th>Note</th>
					<td><strong>
						<?php
							
							$val_note = note($_SESSION['id'],$_GET['idYr']);
							$val_bareme = bareme($_GET['idYr']);
							echo $val_note['note'].'/'.$val_bareme;
						?></strong></td>
					<td></td>
					<td></td>

				</tr>
	</tfoot>
</table>
	<?php

		$idUser = $_SESSION['id'];
		$idYr = $_GET['idYr'];
		$niv = $_GET['niv'];
		

?>
<br/><br/><br/>

	
</p>
<?php 

}

?>
