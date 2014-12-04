function suppr_offre(objet){
    document.getElementById('blackscreen').style.display = '';
    document.getElementById('h1_msg').innerHTML = 'Attention !';
    document.getElementById('txt_msg').innerHTML = 'Voulez-vous vraiment supprimer cette offre ?';
    document.getElementById('btn_valider').style.display = '';
    document.getElementById('btn_valider').onclick = function suppression_offre(){
		var id = objet.id.replace("offre",""); 
		$.post("/ajax/delete_offre.php?notif=" + id, function( data ) {
			document.getElementById('h1_msg').innerHTML = 'Suppression réussie';
			document.getElementById('txt_msg').innerHTML = 'Votre offre a bien été supprimée.';
			document.getElementById('btn_valider').style.display = 'none';
			document.getElementById('btn_fermer').onclick = function revenir_accueil(){
				window.location.replace("/index.php");
			}
		});
	};
}

