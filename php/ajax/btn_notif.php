<?php
	include '../session.inc'; check_login();
	
	$db= mysql_connect('localhost','castage','castage');
	mysql_select_db('castage',$db);
	$sql="SELECT COUNT(IdNotif) FROM notif WHERE IdUser = ".$_SESSION['id']." AND Vu = 0;";
	$req=mysql_query($sql);
	$retour=mysql_fetch_array($req, MYSQL_BOTH);
	echo $retour[0]." Notifications";
	//echo rand(1,100).' Notifications';
?>
