<?php
require_once('fonction_users.php');

function navigation($idUser,$niv){
	$student; 
	if($idUser == 1){
		$student = getUserDetails(1);
	}
	else {
		$student = getUserDetails($idUser);
	}

	echo '
		<div class="navbar">
		 <a style = "text-decoration: none" href="accueil.php?id='.$idUser."&niv=".$niv.'">Home</a>
		 
		  <a style = "text-decoration: none" href="annee.php?id='.$idUser."&niv=".$niv.'">Sujets</a>';



		  if(isset($_SESSION['id'])){
		  echo '

			 <div class="dropdown">
    			<button class="dropbtn">'.$student['prenom'].' '.$student['nom'].
     			 	'<i class="fa fa-caret-down"></i>
    			</button>
    			<div class="dropdown-content">';
      				if ($idUser != 1) {
						echo '<a href="profil.php?id='.$idUser.'&niv='.$niv.'">Profil</a>';
					}
				    if ($idUser == 1) {
					echo '<a href="fiche.php?id='.$idUser.'&niv='.$niv.'">Fiche étudiants</a>
					<a href="valarnilai.php?id='.$idUser.'&niv='.$niv.'">Niveaux</a>';
					}

					echo '<a href="deconnexion.php">Log out</a>
   				 </div>
  			</div>';
  		} 
  		
  		else {
  			echo '
  			<div class="connect">
  			<a style = "text-decoration: none" href="connexion.php">Se connecter</a>
  			</div>';
  		}

  		echo '</div>

			 	 
	';



}

function navigation_style(){
	echo '
<style>


.navbar {
  overflow: hidden;
  background-color: #333;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #ffff99;
  color: black;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #333;
  min-width: 105px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ffff99;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
	';
}