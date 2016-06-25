
$(document).ready(function() {
	$("#getAccessForm").submit(function(){ 
		var form = $(this); 
		var error = false; 

		// form.find('input, textarea').each( function(){
		// 	if ($(this).val() == '') {
		// 		alert('Зaпoлнитe пoлe "'+$(this).attr('placeholder')+'"!');
		// 		error = true; // oшибкa
		// 	}
		// });

		if (!error) {
			var data = form.serialize();
			$.ajax({ 
			   	type: 'POST', 
			   	url: '/validators/emailValidator.php',
			   	data: data,
		       	beforeSend: function() {
		       	     $("#checkPanel").addClass("loading");
		       	},
		       	success: function(data){
		       		if (data['error']) {
		       			alert(data['error']); 
		       		} else {
		       			$('#result').html(data);
		       		}
		       	},
		       	error: function (xhr, ajaxOptions, thrownError) { 
		       	    alert(xhr.status);
		       	    alert(thrownError);
		       	},
		       	complete: function() { 
		       	    $("#checkPanel").removeClass("loading");
		       	    document.getElementById('getAccessForm').reset();
		       	}
		       	           
			});
		}
		return false; 
	});
});	
