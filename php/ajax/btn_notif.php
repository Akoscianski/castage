<?php
	include '../session.inc'; check_login();
	
	$db= connect();
	$sql="SELECT COUNT(IdNotif) FROM notif WHERE IdUser = ".$_SESSION['id']." AND Vu = 0;";
	$req=mysqli_query($db,$sql);
	$retour=mysqli_fetch_array($req, MYSQL_BOTH);
	echo $retour[0]." Notifications";
	//echo rand(1,100).' Notifications';
?>
