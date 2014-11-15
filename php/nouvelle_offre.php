<?php
	include 'session.inc';
	
	$intitule = htmlentities($_POST['intitule'], ENT_QUOTES);
	$entreprise = htmlentities($_POST['entreprise'], ENT_QUOTES);
	$description = htmlentities($_POST['description'], ENT_QUOTES);
	$IdUser = $_SESSION['id'];
		
	$db= mysql_connect('localhost','castage','castage');
	mysql_select_db('castage',$db);
	$sql= 'SELECT IdEntreprise FROM entreprise WHERE Nom = \''.$entreprise.'\';';
	$req = mysql_query($sql);
	
	if(mysql_num_rows($req) > 0){ //On a trouvé une entreprise du même nom
		$retour=mysql_fetch_row($req);
		$IdEntreprise = $retour[0];
	}else{
		$sql1 = 'INSERT INTO entreprise (Nom) VALUES (\''.$entreprise.'\');';
		$req = mysql_query($sql1);
		$sql= 'SELECT IdEntreprise FROM entreprise WHERE Nom = \''.$entreprise.'\';';
		$req = mysql_query($sql);
		if(mysql_num_rows($req) > 0){
			$retour=mysql_fetch_row($req);
			$IdEntreprise = $retour[0];
		}else{
			echo "<p>L'insertion d'entreprise a échouée.</p>";
			$IdEntreprise = -1;
		}
	}
	
	$sql = 'INSERT INTO offres_stages (IdUser, Intitule, IdEntreprise, Description) VALUES ('.$IdUser.',\''.$intitule.'\','.$IdEntreprise.',\''.$description.'\');';
	$req = mysql_query($sql);
	if($req){//insertion dans la base de donnée sans problème
		$notification =htmlentities("Votre proposition d'offre de stage \"".html_entity_decode($intitule, ENT_QUOTES)."\" a bien été enregistrée.", ENT_QUOTES);
		$sql = 'INSERT INTO notif (IdUser, NDate, Vu, Notification) VALUES ('.$IdUser.",NOW(),0, '".$notification."');";
		$req = mysql_query($sql);
		if($req){
			header('Location: index.php');
		}else{
			echo "<p><b>ERREUR 001 :</b> Une erreur s'est produite dans la base de donnée.</p>";
			echo mysql_error();
		}
	}else{
		echo "<p><b>ERREUR 001 :</b> Une erreur s'est produite dans la base de donnée.</p>";
		echo mysql_error();
	}
?>
