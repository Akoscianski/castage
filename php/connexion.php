<?php include("./functions.php"); ?>
<?php get_header();?>
	<h1>Connexion</h2>
	<p>Veuillez entrer vos identifiants pour continuer.</p>
	<form method="post" action="traitement.php">
		<table>
			<tr>
				<td>Nom</td>
				<td><input type="text" name="nom" /></td>
			</tr>
			<tr>
				<td>Mot de passe</td>
				<td><input type="password" name="pswd" :></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Envoyer" /></td>
			</tr>
		</table>
	</form>
<?php get_sidebar();?>
<?php get_footer();?>
