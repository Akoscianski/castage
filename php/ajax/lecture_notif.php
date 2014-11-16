<?php
	include '../session.inc'; check_login();
	
	if(isset($_GET['notif'])){
		$IdNotif = $_GET['notif'];
		$db= mysql_connect('localhost','castage','castage');
		mysql_select_db('castage',$db);
		$sql="UPDATE notif SET Vu = 1 WHERE IdNotif = ".$IdNotif." AND IdUser=".$_SESSION['id'].";";
		$req=mysql_query($sql);
		mysql_close();
	}
?>
