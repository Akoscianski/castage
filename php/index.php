<?php include("./functions.php"); ?>
<?php get_header();?>
	<?php if(isset($_GET["offre"])): ?>
		<?php
			/*
			 * 
			 *  Affichage d'une offre passée en paramètre de l'adresse 
			 * 
			 */
			/* recupération des informations de l'offre */
			$IdOffre = $_GET["offre"];
			$db= connect();
			$sql="SELECT s.IdOffre, s.ODate, e.Nom, s.Intitule, s.Description FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." AND s.IdOffre=".$IdOffre."";
			$req=mysqli_query($db,$sql);
		?>
		<?php if(mysqli_num_rows($req) > 0) : ?>
			<?php 
				$retour=mysqli_fetch_array($req, MYSQL_BOTH);
				echo '<H1>'.$retour["Intitule"].'</H1>';
				echo '<p>Offre déposée le '.$retour["ODate"].'</p>';
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
						echo '<input type="button" name="valid" value="Demander la validation" id="valid'.$retour["IdOffre"].'" onclick="demande_validation(this)" />';
					}else{
						echo '<input type="button" name="valid" value="Demande de validation envoyée" id="valid'.$retour["IdOffre"].'" onclick="" disabled="true"/>';
					}
					echo '<input type="button" name="supp" value="Supprimer" id="offre'.$retour["IdOffre"].'" onclick="suppr_offre(this)" /> ';
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
				$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
					FROM offres_stages s, entreprise e 
					WHERE s.IdEntreprise = e.IdEntreprise 
					AND s.IdUser = ".$_SESSION['id']." 
					AND NOT EXISTS (SELECT v.IdOffre
						FROM demande_validation v
						WHERE v.IdOffre = s.IdOffre)
					ORDER BY IdOffre DESC";
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
				$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) 
					FROM offres_stages s, entreprise e, demande_validation v 
					WHERE s.IdEntreprise = e.IdEntreprise
					AND s.IdUser = ".$_SESSION['id']." 
					AND s.IdOffre = v.IdOffre
					ORDER BY IdOffre DESC";
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
		</div>
	<?php endif; ?>
	<div class="clear"></div>
<?php get_sidebar();?>
<?php get_footer();?>
