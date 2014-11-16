function btn_notif(){
	var targetElement;
	targetElement = document.getElementById("listenotif") ;
	if (targetElement.style.display == "none")
	{
		targetElement.style.display = "" ;
	} else {
		targetElement.style.display = "none" ;
	}
}

$(document).ready(
	setInterval(function verif_notif(){
		var url = '/ajax/btn_notif.php';
			$.post(url, function(data){
				$('#butnotif').html(data);
			});
	},5000)
);



