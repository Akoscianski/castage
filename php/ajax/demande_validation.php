<?php
	include '../session.inc'; check_login();
	
	if(isset($_GET['offre'])){
		$IdOffre = $_GET['offre'];
		$db= connect();
		$sql="INSERT INTO demande_validation VALUES(".$IdOffre.", NOW());";
		$req=mysqli_query($db,$sql);
		mysqli_close($db);
	}
?>
