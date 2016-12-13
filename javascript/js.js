
function bearbeiten(id) {
	
	
	var benutzer = id.substring(18);
	var bereich = document.getElementById(benutzer + "_title");
	bereich.class
	alert(benutzer + "_title");
	
	//var bereich = document.getElementById("RBoehm_title");
	//var absaetze = bereich.getElementsByTagName("p");
	//absaetze.style.color = "red";
	document.getElementById(benutzer).className='td_bearbeiten';
	//document.getElementById(benutzer).style.display = "inline";
}

function speichern() {
	document.getElementById(form).className='td_speichern';

}