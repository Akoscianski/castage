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

?>
