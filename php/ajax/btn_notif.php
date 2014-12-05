<?php
	include '../session.inc'; check_login();
	
	$db= connect();
	$sql="SELECT COUNT(IdNotif) FROM notif WHERE IdUser = ".$_SESSION['id']." AND Vu = 0;";
	$req=mysqli_query($db,$sql);
	$retour=mysqli_fetch_array($req, MYSQL_BOTH);
	$nombre = $retour[0];
	if($_SESSION['type'] == "admin"){
		/* Compter les notifications en broadcast */
		$sql="SELECT COUNT(*) FROM demande_validation d WHERE NOT EXISTS(SELECT IdOffre FROM validation v WHERE v.IdOffre = d.IdOffre);";
		$req=mysqli_query($db,$sql);
		$retour=mysqli_fetch_array($req, MYSQL_BOTH);
		if($retour[0] > 0){
			$nombre = $nombre + 1;
		}
	}
	echo $nombre." Notifications";
?>
