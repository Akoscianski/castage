<?php
	include 'session.inc';
	
	$intitule = htmlentities($_POST['intitule'], ENT_QUOTES);
	$entreprise = htmlentities($_POST['entreprise'], ENT_QUOTES);
	$description = htmlentities($_POST['description'], ENT_QUOTES);
	$IdUser = $_SESSION['id'];
		
	$db= connect();
	$sql= 'SELECT IdEntreprise FROM entreprise WHERE Nom = \''.$entreprise.'\';';
	$req = mysqli_query($db,$sql);
	
	if(mysqli_num_rows($req) > 0){ //On a trouvé une entreprise du même nom
		$retour=mysqli_fetch_row($req);
		$IdEntreprise = $retour[0];
	}else{
		$sql1 = 'INSERT INTO entreprise (Nom) VALUES (\''.$entreprise.'\');';
		$req = mysqli_query($db,$sql1);
		$sql= 'SELECT IdEntreprise FROM entreprise WHERE Nom = \''.$entreprise.'\';';
		$req = mysqli_query($db,$sql);
		if(mysqli_num_rows($req) > 0){
			$retour=mysqli_fetch_row($req);
			$IdEntreprise = $retour[0];
		}else{
			echo "<p>L'insertion d'entreprise a échouée.</p>";
			$IdEntreprise = -1;
		}
	}
	
	$sql = 'INSERT INTO offres_stages (IdUser, Intitule, IdEntreprise, Description) VALUES ('.$IdUser.',\''.$intitule.'\','.$IdEntreprise.',\''.$description.'\');';
	$req = mysqli_query($db,$sql);
	if($req){//insertion dans la base de donnée sans problème
		$notification =htmlentities("Votre proposition d'offre de stage \"".html_entity_decode($intitule, ENT_QUOTES)."\" a bien été enregistrée.", ENT_QUOTES);
		$sql = 'INSERT INTO notif (IdUser, NDate, Vu, Notification) VALUES ('.$IdUser.",NOW(),0, '".$notification."');";
		$req = mysqli_query($db,$sql);
		if($req){
			header('Location: index.php');
		}else{
			echo "<p><b>ERREUR 001 :</b> Une erreur s'est produite dans la base de donnée.</p>";
			echo mysqli_error($db);
		}
	}else{
		echo "<p><b>ERREUR 001 :</b> Une erreur s'est produite dans la base de donnée.</p>";
		echo mysqli_error($db);
	}
?>
