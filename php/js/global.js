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

function demande_validation(objet){
	var id = objet.id.replace("valid","");
	$.post("/ajax/demande_validation.php?offre=" + id, function( data ) {
		document.getElementById('blackscreen').style.display = '';
		document.getElementById('h1_msg').innerHTML = 'Validation en attente';
		document.getElementById('txt_msg').innerHTML = 'Une demande de validation a été envoyée pour cette offre.';
		document.getElementById('btn_fermer').onclick = function revenir_accueil(){
			window.location.replace("/index.php");
		}
	});
}

function validation(objet){
	var id = objet.id.replace("valider","");
	$.post("/ajax/validation.php?offre=" + id, function( data ) {
		document.getElementById('blackscreen').style.display = '';
		document.getElementById('h1_msg').innerHTML = 'Validation effectuée';
		document.getElementById('txt_msg').innerHTML = 'Vous avez bien validé la demande';
		document.getElementById('btn_fermer').onclick = function revenir_accueil(){
			window.location.replace("/index.php");
		}
	});
}
