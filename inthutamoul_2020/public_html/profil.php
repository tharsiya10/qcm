<?php
session_start();
require_once('database.php');
require_once('fonction_style.php');

if(isset($_SESSION['id'])){
	$idUser = $_SESSION['id'];
	$req = $bdd->query("SELECT * FROM users WHERE idUser = $idUser");
	$infouser = $req->fetch();

	$reqbis = $bdd->prepare("SELECT * FROM notes WHERE idUser = ?");
	$reqbis->execute(array($idUser));


}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Page de profil</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="profil.css">
	<?php navigation_style();?>
</head>
<body>
	<?php navigation($_SESSION['id'],$_GET['niv']);?>

	<style type="text/css">
		h1{
			text-align: center;
		}

		.back, .back:hover, .back:visited {
			cursor: pointer;
			position: absolute;
			left: 10px;
			background-color: black;
			color: white;
			font-size: 16px;
		}

		a {
			color: black;
		}
	</style>

	<h1>Profil de <?=$infouser['prenom'].' '.$infouser['nom']?></h1>
	<br/><br/>
	<table>
		<thead>
		<tr>
			<th>Année</th>
			<th>Note</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<?php while($val = $reqbis->fetch()){ 
				$reqter = $bdd->prepare("SELECT * FROM annee WHERE idYr = ?");
				$reqter->execute(array($val['idYr']));
				$donnee = $reqter->fetch();

				$val_bareme = bareme($val['idYr']);
				// $requatre = $bdd->prepare("SELECT * FROM notes WHERE idUser = ? && idYr = ?");
				// $requatre->execute(array($_SESSION['id'],$val['idYr']));
				// $info = $requatre->fetch();

	?>
			<td><?=$donnee['year']?></td>
			<td><?=$val['note'].'/'.$val_bareme?></td>
			<td>
				<a href="relecture.php?id=<?=$_SESSION['id']?>&niv=<?=$_GET['niv']?>&idYr=<?=$val['idYr']?>">Relecture</a>
					

				</td> 
			</tr>
		<?php } ?>
		</tbody>
	</table>

	

</body>
</html>

