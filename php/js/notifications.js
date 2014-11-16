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
	function verif_notif1(){
		var url = '/ajax/btn_notif.php';
		$.post(url, function(data){
			$('#butnotif').html(data);
		})
});
$(document).ready(
	setInterval(function verif_notif(){
		var url = '/ajax/btn_notif.php';
		$.post(url, function(data){
			$('#butnotif').html(data);
		});
	},5000)
);

function read_notif(IdElement){
	var targetElement;
	var nosNotif;
	targetElement = document.getElementById(IdElement);
	nosNotif = IdElement.slice(5);
	if(targetElement.className == "notification0"){
		$.post('/ajax/lecture_notif.php?notif='.concat(nosNotif), function(data){
			//alert(data)
		});
		targetElement.className = "notification1";
		$(document).ready(
			function verif_notif1(){
				var url = '/ajax/btn_notif.php';
				$.post(url, function(data){
					$('#butnotif').html(data);
				})
		});
	}
}


