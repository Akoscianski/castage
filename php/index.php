<?php include("./functions.php"); ?>
<?php get_header();?>
	<?php if(isset($_GET["offre"])): ?>
		<?php
			$IdOffre = $_GET["offre"];
			$db= connect();
			$sql="SELECT s.IdOffre, s.ODate, e.Nom, s.Intitule, s.Description FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." AND s.IdOffre=".$IdOffre."";
			$req=mysqli_query($db,$sql);
		?>
		<?php if(mysqli_num_rows($req) > 0): ?>
			<?php $retour=mysqli_fetch_array($req, MYSQL_BOTH); ?>
			<H1><?php echo $retour["Intitule"]; ?></H1>
			<p>Offre déposée le <?php echo $retour["ODate"]; ?></p>
			<p><b><?php echo $retour["Nom"]; ?></b></p>
			<p><?php echo $retour["Description"]; ?></p>
			<p>
				<?php
					$db= connect();
					$sql="SELECT count(*) FROM demande_validation WHERE IdOffre = ".$IdOffre.";";
					$req=mysqli_query($db,$sql);
					$nombre=mysqli_fetch_array($req, MYSQL_BOTH);
				?>
				<?php if($nombre[0] == 0) : ?>
					<input type="button" name="valid" value="Demander la validation" id="valid<?php echo $retour["IdOffre"] ?>" onclick="demande_validation(this)" />
				<?php else : ?>
					<input type="button" name="valid" value="Demande de validation envoyée" id="valid<?php echo $retour["IdOffre"] ?>" onclick="" disabled="true"/>
				<?php endif; ?>
				<input type="button" name="supp" value="Supprimer" id="offre<?php echo $retour["IdOffre"]; ?>" onclick="suppr_offre(this)" /> 
			</p>
		<?php else: ?>
			<H1>Erreur : la page n'a pas pu être trouvée</H1>
		<?php endif; ?>
	<?php else : ?>
		<div class="offres">
			<?php
				$db= connect();
				$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." ORDER BY IdOffre DESC";
				$req=mysqli_query($db,$sql);
			?>
			<?php if(mysqli_num_rows($req) > 0): ?>
			<div>
				<h3>Dernières offres de stage ajoutées</h3>
			</div>
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
