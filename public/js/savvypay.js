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


/*
Code that will act upon submission of edit #editForm
Will post the data to the action URL
*/

$("#showcontent").on('click', '#submitEdit',function(e){

	e.preventDefault();

	var _url = $("#editForm").attr("action");

	$.ajaxSetup({
	  headers: {
	    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  }
	});

	var _data = $("#editForm").serialize();

	  $.ajax({

	      url: _url,

	      type:'POST',

	      dataType:"json",

	      data:_data,

	      success: function(data) {

	          if($.isEmptyObject(data.error)){
	            swal({
	              title: "Updated!",
	              text: "Data updated",
	              icon: "success",
	              button: false,
	              timer: 2000,
	              showCancelButton: false,
	              showConfirmButton: false
	            }).then(
	              function () {
	                window.location.reload(true);
	              },
	            );

	          }else{
	            
	            printUpdateError(data.error);

	          }

	      }

	  });

});


function printUpdateError(msg) {
	$("#error_messages").find("ul").html('');
	$("#error_messages").css('display','block');
	$.each( msg, function( key, value ) {
	  $("#error_messages").find("ul").append('<li>'+value+'</li>');
	});
}
