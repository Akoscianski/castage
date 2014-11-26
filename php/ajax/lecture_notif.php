<?php
	include '../session.inc'; check_login();
	
	if(isset($_GET['notif'])){
		$IdNotif = $_GET['notif'];
		$db= connect();
		$sql="UPDATE notif SET Vu = 1 WHERE IdNotif = ".$IdNotif." AND IdUser=".$_SESSION['id'].";";
		$req=mysqli_query($db,$sql);
		mysqli_close($db);
	}
?>
