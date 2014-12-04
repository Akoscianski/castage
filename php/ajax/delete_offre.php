<?php
	function delete_offre(id){
		include '../session.inc'; check_login();
		if(isset($_GET['offre'])){
			$IdOffre = $_GET['offre'];
			$db= connect();
			$sql="DELETE FROM offres_stages WHERE IdOffre = ".$IdOffre." AND IdUser=".$_SESSION['id'].";";
			$req=mysqli_query($db,$sql);
		}
	}
?>
