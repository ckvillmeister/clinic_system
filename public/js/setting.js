
$('#btn_submit').click(function(){
	var system_name = $('#text_system_name').val(),
		address = $('#text_address').val(),
		branch_no = $('#text_branch_no').val(),
		down_payment = $('#text_dpp').val();

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
		save_settings(system_name, address, branch_no, down_payment);
	}
})

$('#btn_backup').click(function(){
	back_up_database();
});

//Function: Save Settings
function save_settings(system_name, address, branch_no, down_payment){
	$.ajax({
		url: 'settings/save_settings',
		method: 'POST',
		data: {system_name: system_name, address: address, branch_no: branch_no, down_payment: down_payment},
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

//Function: Backup Database
function back_up_database(){
	$.ajax({
		url: 'settings/back_up_database',
		method: 'POST',
		success: function(result) {
			var msg, header;

			header = 'Database Backup';
			msg = 'Database backed up successfully!';
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
			
		}
	})
}