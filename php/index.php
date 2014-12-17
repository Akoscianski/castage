<?php include("./functions.php"); ?>
<script type="text/javascript" src='/js/commentaires.js'></script>
<?php get_header();?>
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
?>
	<?php if(isset($_GET["offre"])): ?>
		<?php aff_offre($_GET["offre"]); ?>
	<?php else : ?>
		<div class="offres">
			<div><h3>Dernières offres de stage ajoutées</h3></div>
			<?php les_offres(); ?>
			<div>
				<h3>Offres en cours de validation</h3>
			</div>
			<?php les_offres_en_validation(); ?>			
			<div>
				<h3>Stages validés</h3>
			</div>
			<?php les_valides(); ?>
		</div>
	<?php endif; ?>
	<div class="clear"></div>
<?php get_sidebar();?>
<?php get_footer();?>
