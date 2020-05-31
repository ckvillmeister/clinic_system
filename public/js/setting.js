
$('#btn_submit').click(function(){
	var system_name = $('#text_system_name').val(),
		branch_no = $('#text_branch_no').val();

	if (branch_no > 99){
		var header = 'Error';
		var msg = 'Branch number must not exceed more than 2 digits';
						
		$('#modal_body_header').html(header);
		$('#modal_body_message').html(msg);
		$('.message_modal_header').removeClass('bg-success');
		$('.message_modal_header').addClass('bg-danger');
		$('.message_icon').removeClass('fas fa-check');
		$('.message_icon').addClass('fas fa-times');
		$('#modal_message').modal({
			backdrop: 'static',
	    	keyboard: false
		});

		setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
	}
	else{
		save_settings(system_name, branch_no);
	}
})

//Function: Save Settings
function save_settings(system_name, branch_no){
	$.ajax({
		url: 'settings/save_settings',
		method: 'POST',
		data: {system_name: system_name, branch_no: branch_no},
		dataType: 'html',
		success: function(result) {
			var msg, header;

			if (result == 1){
				header = 'Saved';
				msg = 'System settings successfully saved!';
			}
			
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('.message_modal_header').removeClass('bg-danger');
			$('.message_modal_header').addClass('bg-success');
			$('.message_icon').removeClass('fas fa-times');
			$('.message_icon').addClass('fas fa-check');
			$('#modal_message').modal({
				backdrop: 'static',
		    	keyboard: false
			});

			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
			setTimeout(function(){ window.location = 'settings'; }, 4000);
			
		}
	})
}