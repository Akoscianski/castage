<?php

function get_header(){
	if(file_exists("header.php")){
			include("header.php");
		}else{
			echo	"<b>ERREUR :</b> impossible de trouver le fichier header.php";
		}
	}
function get_footer(){
	if(file_exists("footer.php")){
			include("footer.php");
		}else{
			echo "<b>ERREUR :</b> Impossible de trouver le fichier footer.php";
		}
	}
function get_sidebar(){
	if(file_exists("sidebar.php")){
			include("sidebar.php");
		}else{
			echo "<b>ERREUR :</b> Impossible de trouver le fichier sidebar.php";
		}
	}

function menu_sidebar($identifiant){
	echo '<li><a href="./index.php">Accueil</a></li>';
	if($identifiant == 'admin'){
		echo '<li>Inscription tutorat</li>';
		echo '<li><a href="envoi_documents.php">Envoi de documents</a></li>';
		echo '<li><a href="calendrier.php">Calendrier</a></li>';
		echo '<li><a href="notes.php">Notation</a></li>';
	}else{
		echo '<li><a href="offre.php">Nouvelle Offre de stage</a></li>';
		echo '<li><a href="envoi_documents.php">Envoi de documents</a></li>';
		echo '<li><a href="calendrier.php">Calendrier</a></li>';
		echo '<li><a href="notes.php">Notes</a></li>';		
	}
	echo '<li><a href="logout.php">Logout</a></li>';
}

function aff_offre($argument){
			$IdOffre = $argument;
			$db= connect();
			if($_SESSION['type'] != 'admin'){
				$sql="SELECT s.IdOffre, s.ODate, e.Nom, s.Intitule, s.Description FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." AND s.IdOffre=".$IdOffre."";
			}else{
				$sql="SELECT s.IdOffre, s.ODate, e.Nom, s.Intitule, s.Description, u.nom, u.prenom, u.IdUser FROM offres_stages s, entreprise e, user u WHERE s.IdEntreprise = e.IdEntreprise AND s.IdOffre=".$IdOffre." AND s.IdUser = s.IdUser;";
			}
			$req=mysqli_query($db,$sql);
			if(mysqli_num_rows($req) > 0){
				$retour=mysqli_fetch_array($req, MYSQL_BOTH);
				echo '<H1>'.$retour["Intitule"].'</H1>';
				echo '<p>Offre déposée le '.$retour["ODate"];
				echo ' par '.$retour["nom"].' '.$retour['prenom'].'</p>';
				echo '<p><b>'.$retour["Nom"].'</b></p>';
				echo '<p>'.$retour["Description"].'</p>';
				echo '<p>';
				
				/*vérification si l'offre est déjà en demande de validation ou pas */
				$db= connect();
				$sql="SELECT count(*) FROM demande_validation WHERE IdOffre = ".$IdOffre.";";
				$req=mysqli_query($db,$sql);
				$nombre=mysqli_fetch_array($req, MYSQL_BOTH);
				if($nombre[0] == 0){
					if($_SESSION['type'] != 'admin'){
						echo '<input type="button" name="valid" value="Demander la validation" id="valid'.$retour["IdOffre"].'" onclick="demande_validation(this)" />';
						echo '<input type="button" name="supp" value="Supprimer" id="offre'.$retour["IdOffre"].'" onclick="suppr_offre(this)" /> ';
					}
				}else{
					// il y a eu une demande de validation pour cette offre
					//vérification de la validation
					$sql="SELECT count(*) FROM validation WHERE IdOffre = ".$IdOffre.";";
					$req=mysqli_query($db,$sql);
					$nombre=mysqli_fetch_array($req, MYSQL_BOTH);
					if($nombre[0] == 0){
						if($_SESSION['type'] != 'admin'){
							echo '<input type="button" name="valid" value="Demande de validation envoyée" id="valid'.$retour["IdOffre"].'" onclick="" disabled="true"/>';
							echo '<input type="button" name="supp" value="Supprimer" id="offre'.$retour["IdOffre"].'" onclick="suppr_offre(this)" /> ';

						}else{
							echo '<input type="button" name="valider" value="Valider la demande" id="valider'.$retour["IdOffre"].'" onclick="validation(this)" />';
						}
					}else{
						echo '<input type="button" name="validé" value="Offre de stage validée" id="valide'.$retour["IdOffre"].'" onclick="" disabled="true"/>';
					}
				}
				echo '</p>';
				commentaires($IdOffre);
		}else{
			/* Le paramètre entré ne correspond pas à une offre autorisée */
			echo "<H1>Erreur : la page n'a pas pu être trouvée</H1>";
		}
}

function les_offres(){
	$db= connect();
	if($_SESSION['type'] != 'admin'){
		$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
			FROM offres_stages s, entreprise e 
			WHERE s.IdEntreprise = e.IdEntreprise 
			AND s.IdUser = ".$_SESSION['id']." 
			AND NOT EXISTS (SELECT v.IdOffre
				FROM demande_validation v
				WHERE v.IdOffre = s.IdOffre)
			ORDER BY IdOffre DESC";
	}else{
		$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
			FROM offres_stages s, entreprise e 
			WHERE s.IdEntreprise = e.IdEntreprise 
			AND NOT EXISTS (SELECT v.IdOffre
				FROM demande_validation v
				WHERE v.IdOffre = s.IdOffre)
			ORDER BY IdOffre DESC";
	}
	$req=mysqli_query($db,$sql);
	if(mysqli_num_rows($req) > 0){
		while($retour=mysqli_fetch_array($req, MYSQL_BOTH)){
			echo "<div id=".$retour["IdOffre"].">";
			echo '<a href="./index.php?offre='.$retour["IdOffre"].'">';
			echo "<h4>".$retour["Intitule"]."</h4>";
			echo "<p><b>".$retour["Nom"]."</b> - ".$retour[3]."...</p></a></div>";
		}
	}else{
		echo '<div id="-1">';
		echo "<p>Vous n'avez pas encore ajouté d'offres de stage</p></div>";
	}
}

function les_offres_en_validation(){
	$db= connect();
	if($_SESSION['type'] != 'admin'){
		$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
			FROM offres_stages s, entreprise e, demande_validation v 
			WHERE s.IdEntreprise = e.IdEntreprise
			AND s.IdUser = ".$_SESSION['id']." 
			AND s.IdOffre = v.IdOffre
			AND NOT EXISTS (SELECT v.IdOffre
				FROM validation v
				WHERE v.IdOffre = s.IdOffre)
			ORDER BY IdOffre DESC";
	}else{
		$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
			FROM offres_stages s, entreprise e, demande_validation v 
			WHERE s.IdEntreprise = e.IdEntreprise 
			AND s.IdOffre = v.IdOffre
			AND NOT EXISTS (SELECT v.IdOffre
				FROM validation v
				WHERE v.IdOffre = s.IdOffre)
			ORDER BY IdOffre DESC";
	}
	$req=mysqli_query($db,$sql);
	if(mysqli_num_rows($req) > 0){
		while($retour=mysqli_fetch_array($req, MYSQL_BOTH)){
			echo "<div id=".$retour["IdOffre"].'">';
			echo '<a href="./index.php?offre='.$retour["IdOffre"].'">';
			echo '<h4>'.$retour["Intitule"].'</h4>';
			echo '<p><b>'.$retour["Nom"].'</b> - '.$retour[3].'...</p></a></div>';	
		}
	}else{
		echo "<div id='-1'><h3>Vous n'avez pas de demande de validation en cours.</h3></div>";
	}
}

function les_valides(){
	$db= connect();
	if($_SESSION['type'] != 'admin'){
		$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
			FROM offres_stages s, entreprise e, validation v 
			WHERE s.IdEntreprise = e.IdEntreprise
			AND s.IdUser = ".$_SESSION['id']." 
			AND s.IdOffre = v.IdOffre
			ORDER BY IdOffre DESC";
	}else{
		$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
			FROM offres_stages s, entreprise e, validation v 
			WHERE s.IdEntreprise = e.IdEntreprise 
			AND s.IdOffre = v.IdOffre
			ORDER BY IdOffre DESC";
	}
	$req=mysqli_query($db,$sql);
	if(mysqli_num_rows($req) > 0){
		while($retour=mysqli_fetch_array($req, MYSQL_BOTH)){
			echo '<div id="'.$retour["IdOffre"].'">';
			echo '<a href="./index.php?offre='.$retour["IdOffre"].'">';
			echo '<h4>'.$retour["Intitule"].'</h4>';
			echo '<p><b>'.$retour["Nom"].'</b> - '.$retour[3].'...</p></a></div>';
		}
	}else{
		echo '<div id="-1">';
		echo "<h3>Vous n'avez pas d'offre de stage validée.</h3></div>";
	}
}

function commentaires($IdOffre){
	echo '<div id="commentaires">';
		les_commentaires($IdOffre);
	echo '</div>';
	echo '<form name="newcom" action="" onSubmit="return false"><table>
			<tr><td></td><textarea name="new_com" id="new_com" rows=5 COLS=80></textarea></td></tr>
			<tr><td><input type="submit" id="newcom'.$IdOffre.'&user'.$_SESSION['id'].'" value="Envoyer" onClick="addCom(this)" onSubmit="return false"/></td></tr>
		</table></form>';
}

function les_commentaires($IdOffre){
	$db= connect();
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
}
?>
