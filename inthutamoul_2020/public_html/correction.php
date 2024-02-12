<?php 
session_start();
require('fonction.php');

$con = mysqli_connect('localhost','root','','tamoul');
$bdd = new PDO('mysql:host=localhost;dbname=tamoul','root','');

echo '<style>
h1 {
	text-align:center;
}
</style>';



?> <!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="correction.css">
	<?php navigation_style(); ?>
</head>
<body>
	<?php navigation($_SESSION['id'],$_GET['niv']); ?>
	
	<h1>Correction</h1>

<?php 

if(isset($_POST['submit'])) {
	if(!empty($_POST['ans'])){

		$val_bareme = bareme($_GET['idYr']);
		
		$selected = $_POST['ans'];
		
		$idYr = $_GET['idYr'];

		$query = "select * from questions where idYr = $idYr";
		$result = mysqli_query($con, $query);

		$correct = array();
		
		$note = 0;

		?>

		<table>
			<thead>
				<tr>
					<th>Question</th>
					<th>Réponse sélectionnée</th>
					<th></th>
					<th>Réponse correcte</th>
				</tr>
			</thead>

			<?php
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

			$idQuest = $row['idQuest'];

			//Insertion et update dans qcm_answered

			insert_qcm_answered($rowbis['idYr'],$row['idQuest'],$_SESSION['id'],$row['rep']);

			
	

		?> 


			<tbody>
				<tr>
					<td><strong><?=$rowbis['quest']?></strong></td>
					<td><?=$row['rep']?></td>
					<td>
						<?php 
							if($selected[$key] == $correct[$key]) {
								$note ++;
				
								$reqbis = $bdd->prepare("UPDATE QCM_answered SET correct = 1 WHERE idQuest = ?");
								$reqbis->execute(array($idQuest));

								echo '<font color="green"> ✔ </font>';
							}


							else {
				
								$reqbis = $bdd->prepare("UPDATE QCM_answered SET correct = 0 WHERE idQuest = ?");
								$reqbis->execute(array($idQuest));

								echo '<font color="red"><strong>x</strong></font>';
							}
			
						?>
					</td>
					<td><?=$rowter['rep']?></td>
				</tr>
			<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th>Note</th>
					<td><strong><?=$note.'/'.$val_bareme?></strong></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>

		

		<?php 

		insert_grade($_SESSION['id'],$_GET['idYr'],$note);

	}
	?> 
	
	<?php
}
?>

</body>
</html>
