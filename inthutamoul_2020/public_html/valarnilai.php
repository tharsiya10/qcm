<?php 
	session_start();
	// require_once('menu.php');

	if(isset($_GET['submit'])){
		header('Location:annee.php?id='.$_SESSION['id'].'&niv='.$_GET['niv']);
	}

	echo '<style> 
	h1 {
		text-align: center;
	}

	body {
		background-color: #fbe8a6;
	}

	select, option {
		font-size: 20px;
		position: relative;
		top: 60%;
    	left: 27%;
    	transform: translateY(-50%);
		 margin: 0 auto;
		background-color: white;
		opacity;0.2;
		width: 50%;
		text-align:center;
		height: 50px;
		border: #777 1px solid;
		border-top-left-radius: 10px;
		border-bottom-left-radius: 10px;
	}

	input[type=submit]{
		left: 550px;
		width: 20%;
		cursor:pointer;
		color:white;
		  font-family:Helvetica, sans-serif;
		  font-weight:bold;
		  font-size:20px;
		  text-align: center;
		  text-decoration:none;
		  background-color:#FFA12B;
		  display:block;
		  position:relative;
		  padding:18px 20px;
		  
		  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
		  text-shadow: 0px 1px 0px #000;
		  filter: dropshadow(color=#000, offx=0px, offy=1px);
		  -webkit-box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
		  -moz-box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
		  box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
		  
		  -webkit-border-radius: 5px;
		  -moz-border-radius: 5px;
		  border-radius: 5px;
	}

	input[type=submit]:active {
		  top:10px;
		  background-color:#F78900;
		  
		  -webkit-box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3px 0 #915100;
		  -moz-box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3pxpx 0 #915100;
		  box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3px 0 #915100;
	}

	input[type=submit]:after {
		content:"";
		  height:100%;
		  width:100%;
		  padding:4px;
		  position: absolute;
		  bottom:-15px;
		  left:-4px;
		  z-index:-1;
		  background-color:#2B1800;
		  -webkit-border-radius: 5px;
		  -moz-border-radius: 5px;
		  border-radius: 5px;
	}
	</style>'

?>

<!DOCTYPE html>
<html>
<head>
	<title>Liste des niveaux</title>
	<meta charset="utf-8">
</head>
<body>

	<h1>Liste des niveaux</h1>
	<br/><br/><br/>
	<form method="GET">
		<SELECT name="niv">
			<OPTION value="5">Valarnilai 5</OPTION>
			<OPTION value="6">Valarnilai 6</OPTION>
			<OPTION value="7">Valarnilai 7</OPTION>
		</SELECT>
		<br/><br/> <br/><br/><br/><br/><br/><br/>
		<input type="submit" name="submit" value="OK">
	</form>

</body>
</html>