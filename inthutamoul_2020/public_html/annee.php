<?php 
	session_start();
	require_once('database.php');
	require_once('fonction_annee.php');
	// require_once('fonction_users.php');
	require_once('fonction_correction.php');
	require_once('fonction.php');
	require_once('fonction_style.php');
	$reqyrtest = $bdd->prepare('SELECT * FROM annee WHERE niv = ?');
	$reqyrtest->execute(array($_GET['niv']));

	$reqyrent = $bdd->prepare('SELECT * FROM annee WHERE niv = ?');
	$reqyrent->execute(array($_GET['niv']));


	if(!isset($_SESSION['id'])) {
		header('Location:connexion.php');
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Consulter les sujets</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="tableau_annee.css" />  
	<link href="https://fonts.googleapis.com/css?family=Alegreya" rel="stylesheet">
	<?php navigation_style(); ?>
</head>
<body>

	<?php navigation($_SESSION['id'],$_GET['niv']); ?>
	
	<h2>Valarnilai <?=$_GET['niv']?></h2>
	
		<br/><br/>
		<div class="tableau">
				<table>
				<thead>
					<tr>
						<th>Sujets</th>
						<?php if($_SESSION['id'] != 1) {?>
						<th>Note</th>
						
					<?php } ?>

					
					</tr>
				</thead>
	<?php 
		//Afficher les noms des unités qui ont été créées
		
		while($affiche = $reqyrtest->fetch()){
			
			$val_annee = $affiche['idYr'];

			$val_note = note($_SESSION['id'],$val_annee);

			$val_grade = get_final_grade($val_annee,$_SESSION['id']);

			$val_bareme = bareme($val_annee);
			
			?>
			<tbody>
				<tr>
				<td>
					
					<a class="link-button" 
					href="pageQCM.php?id=<?= $_SESSION['id'] ?>&niv=<?=$_GET['niv']?>&idYr=<?=$val_annee?>">
						<?=$affiche['year']?></a>
					

					
				</td>
				<td>
					<?php 
						
						if($_SESSION['id'] != 1){
							if(!empty($val_grade) && $val_grade['note'] != 0){
								echo $val_grade['note'].'/100';
							}
							else {
								if(!empty($val_note)){
									echo $val_note['note'].'/'.$val_bareme;
								}
							}
						}
					?>
				</td>
				</tr>
			</tbody>
		<?php 
		} 
		?>
			</table>
		</div>

		
		
		
<?php 
		if($_SESSION['id'] == 1){
			?>
			<br/><br/><br/>
			

			<button class="open-button" onclick="openForm()">+ Ajouter sujet</button>
			<?php 
				if($_SESSION['id'] == 1) {
					if(isset($_POST['titre']) && !empty($_GET['niv'])){
						$titre = htmlentities($_POST['titre']);
						$niv = $_GET['niv'];
						if(isset($_POST['submit'])) {
							add_annee($niv,$titre);
						}
					}


				}
			?>
			<div class="form-popup" id="myForm">
				<form method="post" class="form-container">
					<label>Titre : <input type="text" name="titre" autofocus></label> <br/> <br/><br/>
					
					<input type="submit" class="btn" name="submit" value="Valider">
					<button type="button" class="btn cancel" onclick="closeForm()">Fermer</button>
				</form>

			<?php 
				if(isset($erreur)){
					echo '<font color="red">'.$erreur.'</font>';
				}
			?>
			</div>
	<?php		
		}

?>
<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>	
	
</body>
</html>