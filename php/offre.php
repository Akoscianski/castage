<script type="text/javascript" src='/js/check_form.js'></script>
<?php include("./functions.php"); ?>
<?php get_header();?>
	<h2>Proposer une nouvelle offre de stage</h2>
	<p>Veuillez compléter les champs ci-dessous</p>
	<form name="form1" method="post" action="nouvelle_offre.php">
		<table>
			<tr>
				<td>Intitulé</td>
				<td><input type="text" name="intitule"  id="intitule" onBlur=affiche_bouton() /></td>
			</tr>
			<tr>
				<td>Entreprise</td>
				<td><input type="text" name="entreprise" id="entreprise" onBlur=affiche_bouton() /></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><textarea name="description" id="textarea" rows=10 COLS=80 onBlur=affiche_bouton()></textarea></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" id="submit1" value="Envoyer" disabled="true" /></td>
			</tr>
		</table>
	</form>
<?php get_sidebar();?>
<?php get_footer();?>
