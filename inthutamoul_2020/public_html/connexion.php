<?php 
	session_start();
	require_once('database.php');
	require('fonction.php');
	
	if(isset($_POST['formconnect'])){
		$prenom = htmlentities(trim($_POST['prenom']));
		$nom = htmlentities(trim($_POST['nom']));
		$password = md5($_POST['password']);
		 
		
		if(!empty($prenom) && !empty($nom) && !empty($password)){
			connexion($prenom,$nom,$password);
		}
		else {
			$erreur = "Tous les champs doivent être remplis";
		}
	}

	?>
	

<!DOCTYPE html>

<html>
<head>
	<title>Page de connexion</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="connexion.css" />
</head>
<body>
	<div id="containter">	

	<form method="post">
		<h1>Connexion</h1>
		
			
		<label for="prenom"><b> Prénom :</b></label> 
		<input type="text" name="prenom" id="prenom" placeholder="Entrer votre prénom" autofocus 
		value="<?php if(isset($prenom)){echo $prenom;}?>"/> 
		

		
		<label for="nom"><b> Nom :</b></label> 
		<input type="text" name="nom" id="nom" placeholder="Entrer votre nom" 
		value="<?php if(isset($nom)){echo $nom;}?>"/> 		

		
		<label for="password"><b>Mot de passe :</b></label> 
		<input type="password" name="password" id="password" placeholder="Entrer votre mot de passe"/> 
		
		<!-- <div id="connect"> -->
			<input type="submit" name="formconnect" value="Connexion" /> 
		<!-- </div> -->
		
		<!-- <a href="mdpoublie.php">Mot de passe oublié ?</a> -->
		
		
	</form>
</div>
	
	<?php 
		if(isset($erreur)){
			echo '<font color = "red" >'.$erreur.'</font>';
		}
	?>


</body>
</html>