function suppr_offre(objet){
    document.getElementById('blackscreen').style.display = '';
    document.getElementById('h1_msg').innerHTML = 'Attention !';
    document.getElementById('txt_msg').innerHTML = 'Voulez-vous vraiment supprimer cette offre ?';
    document.getElementById('btn_valider').style.display = '';
    document.getElementById('btn_valider').onclick = function suppression_offre(){
		var id = objet.id.replace("offre",""); 
		$.post('/ajax/delet_offre.php?notif='.id, function(data){
			//alert(data)
		});
		document.getElementById('blackscreen').style.display = 'none';
	};
}

