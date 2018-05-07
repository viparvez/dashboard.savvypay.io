/**
 * Savvypay.io
 * @constructor
 * @param {string} title - functions
 */

function show(id, url) {

	$('#preview').modal('show');
	$("#spinner").show();

	var showUrl = "http://localhost/dashboard.savvypay.io/"+url+"/"+id;
	 
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
	    $("#spinner").hide();
	    $("#preview").find("#showcontent").html(this.responseText);
	  }
	};
	xhttp.open("GET", showUrl, true);
	xhttp.send();

}