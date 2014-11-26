<?php include("./functions.php"); ?>
<?php get_header();?>
	<div id="blackscreen" style="display:none;">
		<div id="err_mess">
			<h1>Titre du message</h1>
			<p>Le texte qui va avec.</p>
			<input type="button" name="fermer" value="Fermer" onclick="document.getElementById('blackscreen').style.display = 'none'"> 
		</div>
	</div>
	<?php if(isset($_GET["offre"])): ?>
		<?php
			$IdOffre = $_GET["offre"];
			$db= mysql_connect('localhost','castage','castage');
			mysql_select_db('castage',$db);
			$sql="SELECT s.IdOffre, e.Nom, s.Intitule, s.Description FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." AND s.IdOffre=".$IdOffre."";
			$req=mysql_query($sql);
		?>
		<?php if(mysql_num_rows($req) > 0): ?>
			<?php $retour=mysql_fetch_array($req, MYSQL_BOTH); ?>
			<H1><?php echo $retour["Intitule"]; ?></H1>
			<p><b><?php echo $retour["Nom"]; ?></b></p>
			<p><?php echo $retour["Description"]; ?></p>
			<input type="button" name="supp" value="Supprimer" onclick="suppr_offre(<?php echo ["IdOffre"]; ?>)" /> 
		<?php else: ?>
			<H1>Erreur : la page n'a pas pu être trouvée</H1>
		<?php endif; ?>
	<?php else : ?>
		<div class="offres">
			<?php
				$db= mysql_connect('localhost','castage','castage');
				mysql_select_db('castage',$db);
				$sql="SELECT s.IdOffre, e.Nom, s.Intitule, LEFT(s.Description,70) FROM offres_stages s, entreprise e WHERE s.IdEntreprise = e.IdEntreprise AND s.IdUser = ".$_SESSION['id']." ORDER BY IdOffre DESC";
				$req=mysql_query($sql);
			?>
			<?php if(mysql_num_rows($req) > 0): ?>
			<div>
				<h3>Dernières offres de stage ajoutées</h3>
			</div>
			<?php while($retour=mysql_fetch_array($req, MYSQL_BOTH)): ?>
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
<?php get_sidebar();?>
<?php get_footer();?>
