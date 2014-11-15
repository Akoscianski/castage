<?php include 'session.inc'; check_login(); ?>
<html>
	<head>
		<title>Cas Stage : site statique</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta charset="UTF-8">
	</head>
	<body>
		<div id="page">
			<div id="ban">
				<a href="./index.php">
					<h1>Cas Stage</h1>
					<p>Connecté en tant que <?php echo $_SESSION['username']; ?>, id : <?php echo $_SESSION['id']; ?></p>
				</a>
			</div>
			<div id="content">
				<div id="article">
