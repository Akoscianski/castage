<?php include("./functions.php"); ?>
<?php get_header();?>
	<?php if(isset($_GET["offre"])): ?>
		<?php
			$IdOffre = $_GET["offre"];
			$db= connect();
			$sql="SELECT s.IdOffre, e.Nom, s.Intitule, s.Description FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." AND s.IdOffre=".$IdOffre."";
			$req=mysqli_query($db,$sql);
		?>
		<?php if(mysqli_num_rows($req) > 0): ?>
			<?php $retour=mysqli_fetch_array($req, MYSQL_BOTH); ?>
			<H1><?php echo $retour["Intitule"]; ?></H1>
			<p><b><?php echo $retour["Nom"]; ?></b></p>
			<p><?php echo $retour["Description"]; ?></p>
			<input type="button" name="supp" value="Supprimer" id="offre<?php echo ["Id Offre"]; ?>" onclick="suppr_offre(this.id)" /> 
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
