<?php
	include '../session.inc'; check_login();
	
	if(isset($_GET['notif'])){
		$IdOffre = $_GET['notif'];
		$db= connect();
		$sql="DELETE FROM offres_stages WHERE IdOffre = ".$IdOffre." AND IdUser=".$_SESSION['id'].";";
		$req=mysqli_query($db,$sql);
		mysqli_close($db);
	}
?>


