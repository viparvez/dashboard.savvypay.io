/**
 * Savvypay.io
 * @constructor
 * @param {string} title - functions
 */

function show(url) {

	$('#preview').modal('show');
	$("#spinner").show();
	 
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    $("#spinner").hide();
	    $("#preview").find("#showcontent").html(this.responseText);
	  }
	};
	xhttp.open("GET", url, true);
	xhttp.send();

}

