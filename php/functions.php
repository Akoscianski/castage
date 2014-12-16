<?php

function get_header(){
	if(file_exists("header.php")){
			include("header.php");
		}else{
			echo	"<b>ERREUR :</b> impossible de trouver le fichier header.php";
		}
	}
function get_footer(){
	if(file_exists("footer.php")){
			include("footer.php");
		}else{
			echo "<b>ERREUR :</b> Impossible de trouver le fichier footer.php";
		}
	}
function get_sidebar(){
	if(file_exists("sidebar.php")){
			include("sidebar.php");
		}else{
			echo "<b>ERREUR :</b> Impossible de trouver le fichier sidebar.php";
		}
	}

function menu_sidebar($identifiant){
	echo '<li><a href="./index.php">Accueil</a></li>';
	if($identifiant == 'admin'){
		echo '<li>Inscription tutorat</li>';
		echo '<li><a href="envoi_documents.php">Envoi de documents</a></li>';
		echo '<li><a href="calendrier.php">Calendrier</a></li>';
		echo '<li><a href="notes.php">Notation</a></li>';
	}else{
		echo '<li><a href="offre.php">Nouvelle Offre de stage</a></li>';
		echo '<li><a href="envoi_documents.php">Envoi de documents</a></li>';
		echo '<li><a href="calendrier.php">Calendrier</a></li>';
		echo '<li><a href="notes.php">Notes</a></li>';		
	}
	echo '<li><a href="logout.php">Logout</a></li>';
}
?>
