<?php include '../session.inc'; check_login(); ?>
<?php
	/* Etape 1 : recupérer les variables transmises */
	/* adresse passée : /ajax/newcom.php?offre=" + id + "&user=" + user + "&com=" + commentaire */
	if(isset($_GET['offre']) && isset($_GET['user']) && isset($_GET['com'])){
		$IdOffre = $_GET['offre'];
		$IdUser = $_GET['user'];
		$Commentaire = $_GET['com'];
		
		
		/* Etape 2 : insertion dans la base de données */
		$db = connect();
		$sql = 'INSERT INTO commentaires_offres VALUES (0,'.$IdOffre.','.$IdUser.', NOW(),\''.$Commentaire.'\');';
		$req=mysqli_query($db,$sql);
		if($req != FALSE){
			// Etpae 3 : récupération et affichage des commentaires
			$sql = 'SELECT c.Com, u.Nom, u.Prenom, c.CDate FROM commentaires_offres c, user u WHERE IdOffre = '.$IdOffre.' AND u.IdUser = c.IdUser;';
			$req=mysqli_query($db,$sql);
			if(mysqli_num_rows($req) > 0){
				while($retour=mysqli_fetch_array($req, MYSQL_BOTH)){
					echo "<div calss='commentaire'>
							<p><b>Le ".$retour['CDate']." par ".$retour['Prenom']." ".$retour['Nom']."</b></p>
							<p><i>".$retour['Com']."</i></p>
						</div>";
				}
			}else{
				echo "<div calss='commentaire'>Il n'y a pas encore de commentaire pour cette offre.</div>";
			}
		}else{
			echo 'Une erreur est survenue dans la base de données.';
		}
	}else{
		echo "Une erreur est survenue sur la page.";
	}
?>
