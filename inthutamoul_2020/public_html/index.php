<?php 
	session_start();
	require_once('database.php');
	// require_once('fonction_users.php');
	require_once('fonction_style.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://fonts.googleapis.com/css?family=Alegreya" rel="stylesheet">
	<?php 
	if(isset($_SESSION['id']) && isset($_GET['niv'])){
		navigation_style();
	}
	?>
	<style type="text/css">
* {box-sizing:border-box}

body {
	overflow: hidden;
	letter-spacing: 0.2em;
}

/* Slideshow container */

.slideshow-container {
  max-width: 500px;
  margin: auto;
  /*float: right;*/
  position: absolute;
  right: 50px;
  top: 150px;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.15s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {

  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: none;
  transition: background-color 0.15s ease;

}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4}
  to {opacity: 1}
}

.gauche {
	width: 50%;
	height: 100%;
	position: absolute;
	background-color: #ffff66;
/*	top: 250px;*/

}

.text-gauche {
	position: absolute;
	top: 200px;
	left: 40px;
}


.btn-connect {
	color: #1a1a1a;
	position: absolute;
	top: 260px;
	right:  60px;
	width: 26%;
	cursor:pointer;
	/*color:black;*/
	font-family:Helvetica, sans-serif;
		  /*font-weight:bold;
		  
		  /*text-align: center;
		  text-decoration:none;*/
		  background-color:#FFA12B;
		  display:block;
		  /*position:relative;*/
		  padding:18px 20px;
		  
		  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
		  text-shadow: 0px 1px 0px #000;
		  filter: dropshadow(color=#000, offx=0px, offy=1px);
		  -webkit-box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
		  -moz-box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
		  box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
		  
		  -webkit-border-radius: 5px;
		  -moz-border-radius: 5px;
		  border-radius: 5px;*/
	}

	.btn-connect:active {
		  background-color:#F78900;
		  
		  -webkit-box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3px 0 #915100;
		  -moz-box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3pxpx 0 #915100;
		  box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3px 0 #915100;
	}

	.btn-connect:after {
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

	</style>

</head>
<body>

	<?php if(isset($_SESSION['id']) && isset($_GET['niv'])){
		navigation($_SESSION['id'],$_GET['niv']);
	}
	?>

	<div class="gauche">
		<div class="text-gauche">
		<h1>Etudier depuis chez vous le tamoul</h1>
		<br/>
		<h3>Facile et accessible</h3>
		<br/><br/>

		<?php 
		if(!isset($_SESSION['id'])){
			echo '
			<div class="btn-gauche">
			<a style="text-decoration:none" class="btn-connect" href="connexion.php">Commencer</a>
			</div>';
		}
		?>
		</div>
	
	</div>

<div class="slideshow-container">

  <!-- Full-width images with number and caption text -->
  <div class="mySlides fade">
    <div class="numbertext"></div>
    <img src="jeune_fille_etudie.jpg" alt="Etudier" style="width:100%">
    <div class="text"></div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext"></div>
    <img src="stay_at_home.jpg" alt="Etudier" style="width:100%">
    <div class="text"></div>
  </div>

<!--   <div class="mySlides fade">
    <div class="numbertext">3 / 3</div>
    <img src="jeune_fille.jpeg" style="width:100%">
    <div class="text">Caption Three</div>
  </div> -->

  <!-- Next and previous buttons -->
  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span>
 <!-- <span class="dot" onclick="currentSlide(3)"></span>  -->
</div>

<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script>


</body>
</html>
