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
		<div id="blackscreen" style="display:none;">
			<div id="err_mess">
				<h1 id="h1_msg">Titre du message</h1>
				<p id="txt_msg">Le texte qui va avec.</p>
				<input type="button" id="btn_valider" name="Valider" value="Valider" onclick="" style="display:none;"/>
				<input type="button" id="btn_fermer" name="fermer" value="Fermer" onclick="document.getElementById('blackscreen').style.display = 'none'"> 
			</div>
		</div>
		<div id="page">
			<div id="ban">
				<a href="./index.php">
					<h1>Cas Stage</h1>
					<p>Connecté en tant que <?php echo $_SESSION['username']; ?>, id : <?php echo $_SESSION['id']; ?> <?php if($_SESSION['type'] == 'admin'){echo "Connecté en tant que Administrateur"; } ?> </p>
				</a>
					<div id="menunotif">
						<div id="butnotif" onClick="javascript:btn_notif();" >0 Notifications</div>
					</div>
					<div id="listenotif" style="display:none;">
						<?php
							$db= connect();
							if($_SESSION['type'] == "admin"){
								/* Compter les notifications en broadcast */
								$sql="SELECT COUNT(*) FROM demande_validation d WHERE NOT EXISTS(SELECT IdOffre FROM validation v WHERE v.IdOffre = d.IdOffre);";
								$requete=mysqli_query($db,$sql);
								$retourner=mysqli_fetch_array($requete, MYSQL_BOTH);
								if($retourner[0] > 0){
									echo '<div class="notification0" id="BCdemandes" onClick="javascript:read_notif(\'notifBC\');">Des demandes de validation sont en attente.</div>';
								}
							}
							$sql="SELECT IdNotif, Vu, notification FROM notif WHERE IdUser = ".$_SESSION['id']." ORDER BY NDate DESC LIMIT 10;";
							$req=mysqli_query($db, $sql);
							if(mysqli_num_rows($req) > 0){
								while($ret=mysqli_fetch_array($req, MYSQL_BOTH)){
									echo '<div class="notification'.$ret['Vu'].'" id="notif'.$ret['IdNotif'].'" onClick="javascript:read_notif(\'notif'.$ret['IdNotif'].'\');">'.$ret['notification'].'</div>';
								}
							}else{
								echo "<p>Vous n'avez pas de notification</p>";
							}
						?>
					</div>
			</div>
			<div id="content">
				<div class="clear"></div>
				<div id="article">
