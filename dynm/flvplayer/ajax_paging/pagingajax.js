/*
MAIN AJAX FUNCTION: xxmlhttprequest2()
*/


$(document).ready(function() {
	$("#preloader").hide();	
});

function xmlhttprequest2(id, url, methods, keyvalue) {
	
	
			//alert(url+'?'+keyvalue);
	
	$("#preloader").show();
	$.ajax({
 	 	type: "GET",
  		url: url+'?'+keyvalue,
		

  		success: function(html){
			$("#preloader").hide();
    		$("#"+id).empty().append(html);
			
  		},
		failure: function(html){
			$("#"+id).innerHTML = "Sorry, please try again..."
		}
		

	});
	
}



