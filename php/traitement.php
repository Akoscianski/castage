<?php include("./functions.php"); ?>
<?php get_header();?>
	<?php
		$nom=$_POST['nom'];
		$mdp=$_POST['pswd'];		
		$db= mysql_connect('localhost','castage','castage');
		mysql_select_db('castage',$db);
		
		$sql= 'SELECT IdUser, Nom, Prenom FROM user WHERE Nom=\''.$nom.'\' AND Mdp= MD5(\''.$mdp.'\');';
		
		$req = mysql_query($sql);
?>
<?php if(mysql_num_rows($req)==1): ?>
	<H1>Utilisateur connecté !</H1>
	<?php $data = mysql_fetch_assoc($req); ?>
	<table>
		<tr>
			<td>Nom</td>
			<td><?php echo $data['Nom']; ?></td>
		</tr>
		<tr>
			<td>Prenom</td>
			<td><?php echo $data['Prenom']; ?></td>
		</tr>
		<tr>
			<td>Nos</td>
			<td><?php echo $data['IdUser']; ?></td>
		</tr>
	</table>
<?php else : ?>
	<H1>Utilisateur non connecté</H1>
	<p>L'utilisateur n'a pas pu être trouvé.</p>
<?php endif; ?>
<?php get_sidebar();?>
<?php get_footer();?>
