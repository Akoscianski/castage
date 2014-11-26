<?php include 'session.inc'; check_login(); ?>
<html>
	<head>
		<title>Cas Stage : site dynamique</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="/js/jQuery.js"></script>
		<script type="text/javascript" src='/js/notifications.js'></script>
		<script type="text/javascript" src='/js/global.js'></script>
		<meta charset="UTF-8">
	</head>
	<body>
		<div id="page">
			<div id="ban">
				<a href="./index.php">
					<h1>Cas Stage</h1>
					<p>Connecté en tant que <?php echo $_SESSION['username']; ?>, id : <?php echo $_SESSION['id']; ?></p>
				</a>
					<div id="menunotif">
						<div id="butnotif" onClick="javascript:btn_notif();" >0 Notifications</div>
					</div>
					<div id="listenotif" style="display:none;">
						<?php
							$db= mysql_connect('localhost','castage','castage');
							mysql_select_db('castage',$db);
							$sql="SELECT IdNotif, Vu, notification FROM notif WHERE IdUser = ".$_SESSION['id']." ORDER BY NDate DESC LIMIT 10;";
							$req=mysql_query($sql);
							if(mysql_num_rows($req) > 0){
								while($retour=mysql_fetch_array($req, MYSQL_BOTH)){
									echo '<div class="notification'.$retour['Vu'].'" id="notif'.$retour['IdNotif'].'" onClick="javascript:read_notif(\'notif'.$retour['IdNotif'].'\');">'.$retour['notification'].'</div>';
								}
							}else{
								echo "<p>Vous n'avez pas de notification</p>";
							}
						?>
						<!--<div class="notification">Et encore une notification encore plus longue que la précédente par ce que voilà quoi, il faut bien voir ce que celà donne si ça dépasse du cadre par ce que j'aime bien mettre des notifications dx fois plus longues que les notifs normales !</div>
						<div class="notification">notif 1</div>
						<div class="notification">Une autre notification un peu plus longue par ce que j'ai quand même prévu de pouvoir en mettre pas mal là dedans...</div>-->
					</div>
			</div>
			<div id="content">
				<div id="article">
