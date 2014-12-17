function addCom(objet){
	var args = objet.id.split("&");
	var id = args[0].replace("newcom","");
	var user = args[1].replace("user","");
	var commentaire = document.forms["newcom"].new_com.value;
	var nombre = document.forms["newcom"].new_com.value.length
	$.post("/ajax/newcom.php?offre=" + id + "&user=" + user + "&com=" + commentaire +"", function( data ) {
		document.getElementById('commentaires').innerHTML = data;
	});
	document.forms["newcom"].new_com.value = "";
}
