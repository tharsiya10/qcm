<?php
session_start();
require_once('fonction_style.php');
require_once('database.php');

if($_SESSION['id'] == 1){ ?>
	

<!DOCTYPE html>
<html>
<head>
	<title>Fiche étudiants</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="tableau.css"> 
	<?php navigation($_SESSION['id'],$_GET['niv']);?>
</head>
<body>
	<?php navigation_style();?>
	<style type="text/css">
		h1{
			text-align: center;
		}

		
		
	</style>

	
	<h1>Fiche étudiants</h1>
	<?php 
	for($i = 5; $i<8; $i++){
		$req1 = $bdd->prepare("SELECT * FROM users WHERE idUser != ? && niv = $i ORDER BY idUser ASC");
		$req1->execute(array(1));
		?>
		<table>
			<tr><th colspan="3">Niveau <?=$i?></th></tr>
		</table>
		<?php
		while($val1 = $req1->fetch()){
			$req2 = $bdd->prepare("SELECT * FROM notes WHERE idUser = ?");
			$req2->execute(array($val1['idUser'])); ?>
			<table>
				
				<!-- <tr><th colspan="3">Niveau <?=$i?></th></tr> -->
				<tr><th colspan="3"><?=$val1['prenom'].' '.$val1['nom']?></th></tr>
				<tr>
				<th>Année</th>
				<th>Note</th>
				<th></th>
				</tr>
				<tr>
			<?php

			while($val2 = $req2->fetch()){
				$req3 = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
				$req3->execute(array($val2['idYr']));
				$val3 = $req3->fetch();
				// $req4 = $bdd->prepare("SELECT * FROM notes WHERE idUser = ? && idYr = ?");
				// $req4->execute(array($$val1['idUser'],$val2['idYr']));
				// $val4 = $req4->fetch(); 
				?>
				<tr>
				<td><?=$val3['year']?></td>
				<td><?=$val2['note']?></td>
				<td><a href="relecture.php?id=<?=$_SESSION['id']?>&idUser=<?=$val1['idUser']?>&niv=<?=$val1['niv']?>&idYr=<?=$val2['idYr']?>">Relecture</a></td></tr>

				<?php
			}
			?> </tr> </table> 
			<?php
		} ?><br/><br/> <?php
	}
	?>
	

</body>
</html>


<?php }  ?>