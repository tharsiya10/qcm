<?php 

function database(){
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=id21321017_tamoul','root','');
		return $bdd;
	}

	catch(PDOException $e){
		print "Erreur de connexion à la base de donnée : ".$e->getMessage();
		die();
	}
}

function connexion($prenom, $nom, $password){
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM users WHERE prenom = ? && nom = ? && password = ?");
	$req ->execute(array($prenom,$nom,$password));
	$exist = $req ->rowCount();
	$info = $req->fetch();

	if($exist == 1 && $info['idUser'] == 1){
		$_SESSION['id'] = 1;
			header("Location: valarnilai.php?id=1&niv=0");
	}

	elseif($exist == 1 && $info['idUser'] != 1){
			
		$_SESSION['id'] = $info['idUser'];
		header("location: accueil.php?id=".$_SESSION['id']."&niv=".$info['niv']);
				
	}
	else {
		echo "Nom d'utilisateur ou mot de passe incorrect";
	}
}


function note($idUser, $idYr){
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM notes WHERE idUser = ? && idYr = ?");
	$req->execute(array($idUser,$idYr));
	$val = $req->fetch();
	return $val;
}






/* fonctions spécifiques */




function insert_grade($idUser,$idYr,$note){
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM notes WHERE idUser = ? AND idYr = ?");
	$req->execute(array($idUser,$idYr));
	$note_exist = $req->rowCount();

	if($note_exist != 0) {
		$up = $bdd->prepare('UPDATE notes SET note = ? WHERE idUser = ? AND idYr = ?');
		$up->execute(array($note,$idUser,$idYr));
			
	}

	else {
		$insert = $bdd->prepare("INSERT INTO notes(idUser,idYr,note) VALUES(?,?,?)");
		$insert->execute(array($idUser,$idYr,$note));
	}
}

function bareme($idYr){
	$con = mysqli_connect('localhost','root','','id21321017_tamoul');
	$query = "select * from questions where idYr = $idYr";
	$result = mysqli_query($con, $query);
	$bareme = 0;
	while($rows = mysqli_fetch_array($result)){
		$bareme++;
	}
	return $bareme;
}

function questions($idQuest){
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM questions WHERE idQuest = ?");
	$req->execute(array($idQuest));
	$val_id = $req->fetch();

	return $val_id;
}

function reponses($idQuest, $ans_id) {
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM reponses WHERE idQuest = ? && idRep = ?");
	$req->execute(array($idQuest, $ans_id));
	$val_id = $req->fetch();

	return $val_id;
}


function correct_answer($idYr, $idQuest){
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM questions WHERE idYr = ? && idQuest = ?");
	$req->execute(array($idYr,$idQuest));
	$val_id = $req->fetch();

	$req_ans = $bdd->prepare("SELECT * FROM reponses WHERE idYr = ? && idQuest = ? && idRep = ?");
	$req_ans->execute(array($idYr,$idQuest, $val_id['ans_id']));
	$val = $req_ans->fetch();
	return $val;
}

function users($idUser) {
	$bdd = database();
	$req = $bdd->prepare("SELECT * FROM users WHERE idUser = ?");
	$req->execute(array($idUser));
	$val = $req->fetch();
	return $val;
}

?>
