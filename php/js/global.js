function suppr_offre(Id){
	//alert(this.id);
	var nos = this.id;
    document.getElementById('blackscreen').style.display = '';
    document.getElementById('h1_msg').innerHTML = 'Attention !';
    document.getElementById('txt_msg').innerHTML = 'Voulez-vous vraiment supprimer cette offre ?';
    document.getElementById('btn_valider').style.display = '';
    //alert('Offre nos : '+nos);
    document.getElementById('btn_valider').onclick = function suppression_offre(nos){
		alert('Hello'+IdOffre);
		document.getElementById('btn_valider').style.display = 'none';
	};
}

