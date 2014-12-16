<?php include("./functions.php"); ?>
<?php get_header();?>
	<?php if(isset($_GET["offre"])): ?>
		<?php
			/*
			 * 
			 *  Affichage d'une offre passée en paramètre de l'adresse 
			 * 
			 * A faire : demande de validation
			 * 			- demande de convention
			 * 			- Validation / Refu de l'offre	(ADMIN)
			 * 			- Ajoute de commentaire pour converser
			 *          - Modification de l'offre
			 * 			- Demande annulation de validation
			 * 			- Acceptation convention	(ADMIN)
			 * 			- Affectation tuteur
			 * 			- Interruption du stage
			 */
			/* recupération des informations de l'offre */
			$IdOffre = $_GET["offre"];
			$db= connect();
			if($_SESSION['type'] != 'admin'){
				$sql="SELECT s.IdOffre, s.ODate, e.Nom, s.Intitule, s.Description FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." AND s.IdOffre=".$IdOffre."";
			}else{
				$sql="SELECT s.IdOffre, s.ODate, e.Nom, s.Intitule, s.Description, u.nom, u.prenom, u.IdUser FROM offres_stages s, entreprise e, user u WHERE s.IdEntreprise = e.IdEntreprise AND s.IdOffre=".$IdOffre." AND s.IdUser = s.IdUser;";
			}
			$req=mysqli_query($db,$sql);
		?>
		<?php if(mysqli_num_rows($req) > 0) : ?>
			<?php 
				$retour=mysqli_fetch_array($req, MYSQL_BOTH);
				echo '<H1>'.$retour["Intitule"].'</H1>';
				echo '<p>Offre déposée le '.$retour["ODate"];
				echo ' par '.$retour["nom"].' '.$retour['prenom'].'</p>';
				echo '<p><b>'.$retour["Nom"].'</b></p>';
				echo '<p>'.$retour["Description"].'</p>';
			?>
			<p>
				<?php
					/*vérification si l'offre est déjà en demande de validation ou pas */
					$db= connect();
					$sql="SELECT count(*) FROM demande_validation WHERE IdOffre = ".$IdOffre.";";
					$req=mysqli_query($db,$sql);
					$nombre=mysqli_fetch_array($req, MYSQL_BOTH);
					if($nombre[0] == 0){
						if($_SESSION['type'] != 'admin'){
							echo '<input type="button" name="valid" value="Demander la validation" id="valid'.$retour["IdOffre"].'" onclick="demande_validation(this)" />';
						}
					}else{
						if($_SESSION['type'] != 'admin'){
							echo '<input type="button" name="valid" value="Demande de validation envoyée" id="valid'.$retour["IdOffre"].'" onclick="" disabled="true"/>';
						}else{
							echo '<input type="button" name="valider" value="Valider la demande" id="valider'.$retour["IdOffre"].'" onclick="validation(this)" />';
						}
					}
					if($_SESSION['type'] != 'admin'){
						echo '<input type="button" name="supp" value="Supprimer" id="offre'.$retour["IdOffre"].'" onclick="suppr_offre(this)" /> ';
					}
				?>
			</p>
		<?php else : ?>
			<?php /* Le paramètre entré ne correspond pas à une offre autorisée */ ?>
			<H1>Erreur : la page n'a pas pu être trouvée</H1>
		<?php endif; ?>
	<?php else : ?>
		<?php /* On affiche les offres / page d'accueil */ ?>
		<div class="offres">
			<div>
				<h3>Dernières offres de stage ajoutées</h3>
			</div>
			<?php
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
			?>
			<?php if(mysqli_num_rows($req) > 0): ?>
			<?php while($retour=mysqli_fetch_array($req, MYSQL_BOTH)): ?>
				<div id="<?php echo $retour["IdOffre"]; ?>">
					<a href="./index.php?offre=<?php echo $retour["IdOffre"]; ?>">
						<h4><?php echo $retour["Intitule"]; ?></h4>
						<p><b><?php echo $retour["Nom"]; ?></b> - <?php echo $retour[3]; ?>...</p>
					</a>
				</div>
			<?php endwhile; ?>
			<?php else: ?>
				<div id="-1">
					<h3>Vous n'avez pas encore ajouté d'offres de stage</h3>
				</div>
			<?php endif; ?>
			<div>
				<h3>Offres en cours de validation</h3>
			</div>
			<?php
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
			?>
			<?php if(mysqli_num_rows($req) > 0): ?>
			<?php while($retour=mysqli_fetch_array($req, MYSQL_BOTH)): ?>
				<div id="<?php echo $retour["IdOffre"]; ?>">
					<a href="./index.php?offre=<?php echo $retour["IdOffre"]; ?>">
						<h4><?php echo $retour["Intitule"]; ?></h4>
						<p><b><?php echo $retour["Nom"]; ?></b> - <?php echo $retour[3]; ?>...</p>
					</a>
				</div>
			<?php endwhile; ?>
			<?php else: ?>
				<div id="-1">
					<h3>Vous n'avez pas de demande de validation en cours.</h3>
				</div>
			<?php endif; ?>
			
			<div>
				<h3>Stages validés</h3>
			</div>
			<?php
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
			?>
			<?php if(mysqli_num_rows($req) > 0): ?>
			<?php while($retour=mysqli_fetch_array($req, MYSQL_BOTH)): ?>
				<div id="<?php echo $retour["IdOffre"]; ?>">
					<a href="./index.php?offre=<?php echo $retour["IdOffre"]; ?>">
						<h4><?php echo $retour["Intitule"]; ?></h4>
						<p><b><?php echo $retour["Nom"]; ?></b> - <?php echo $retour[3]; ?>...</p>
					</a>
				</div>
			<?php endwhile; ?>
			<?php else: ?>
				<div id="-1">
					<h3>Vous n'avez pas d'offre de stage validée.</h3>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<div class="clear"></div>
<?php get_sidebar();?>
<?php get_footer();?>
