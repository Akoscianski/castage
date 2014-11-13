function affiche_bouton()
{ 
   var Checked=1;
 
   for (i=0; i<document.getElementsByTagName("input").length; i++){
      if(document.getElementsByTagName("input")[i].value == "")
		Checked=0;
	}
	if(document.getElementById("textarea").value == "")
		Checked=0;
 
   if (Checked == 1)
   {
      document.getElementById('submit1').disabled='';
   } else {
      document.getElementById('submit1').disabled='true';
   }
}
