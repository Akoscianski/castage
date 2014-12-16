<?php
	include '../session.inc'; check_login();
	
	if(isset($_GET['offre'])){
		$IdOffre = $_GET['offre'];
		$db= connect();
		$sql="INSERT INTO validation VALUES(".$IdOffre.", NOW(), ".$_SESSION['id'].");";
		$req=mysqli_query($db,$sql);
		mysqli_close($db);
	}
?>
