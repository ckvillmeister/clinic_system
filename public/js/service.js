var global_id;
var global_action;
retrieve_services(1);

$('#text_name').on('change', function() {
	$('#text_name').removeClass('is-invalid');
});

$('#text_description').on('change', function() {
	$('#text_description').removeClass('is-invalid');
});

$('#text_rate').on('change', function() {
	$('#text_rate').removeClass('is-invalid');
});

$('#btn_new_service').click(function(){
	clear();
	global_action = 'add';
	$("#modal_service_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('#btn_active').click(function(){
	retrieve_services(1);
})

$('#btn_inactive').click(function(){
	retrieve_services(0);
})

$('body').on('click', '#btn_edit_control', function(){
	global_id = $(this).val();
	global_action = 'edit';
	get_service_info(global_id);
	$("#modal_service_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('body').on('click', '#btn_delete_control', function(){
	$("#modal_confirm").modal({
		backdrop: 'static',
    	keyboard: false
	});
	$('#modal_confirm_message').html("Are you sure you want to remove this record?");
	global_id = $(this).val();
	global_action = 'remove';
});

$('body').on('click', '#btn_reactivate_control', function(){
	$("#modal_confirm").modal({
		backdrop: 'static',
    	keyboard: false
	});
	$('#modal_confirm_message').html("Are you sure you want to re-activate this record?");
	global_id = $(this).val();
	global_action = 'reactivate';
});

$('#btn_submit').click(function(){
	var name = $('#text_name').val(),
		description = $('#text_description').val(),
		rate = $('#text_rate').val(),
		error = false;

	if (name == ''){
		$('#text_name').addClass('is-invalid');
		error = true;
	}

	if (rate == ''){
		$('#text_rate').addClass('is-invalid');
		error = true;
	}

	if(!(rate.match(/^\d+.\d+$/))) {
		$('#text_rate').addClass('is-invalid');
	    error = true;
	}

	if (error == false){
		if (global_action=='edit'){
			insert_service(global_id, name, description, rate);
		}
		else if (global_action=='add'){
			insert_service('', name, description, rate);
		}
		
	}
})

$('#btn_yes').click(function(){
	if (global_action == 'remove'){
		toggle_service_status(global_id, 0);
	}
	else if (global_action == 'reactivate'){
		toggle_service_status(global_id, 1);
	}
})

//Function: Save Patient Info
function insert_service(id, name, description, rate){
	$.ajax({
		url: 'service/insert_service',
		method: 'POST',
		data: {id: id, name: name, description: description, rate: rate},
		dataType: 'html',
		success: function(result) {
			var msg, header;

			if (result == 1){
				header = 'Saved';
				msg = 'Service information successfully saved!';
			}
			else if (result == 2){
				header = 'Updated';
				msg = 'Service information successfully updated!';
			}
			
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('#modal_message').modal({
				backdrop: 'static',
		    	keyboard: false
			});

			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
			setTimeout(function(){ $('#modal_service_form').modal('toggle'); }, 3000);
			setTimeout(function(){ retrieve_services(1); }, 4000);
			setTimeout(function(){ clear(); }, 4000);
		}
	})
}

//Function: Retrieve All Services
function retrieve_services(status){
	$.ajax({
		url: 'service/retrieve_services',
		method: 'POST',
		data: {status: status},
		dataType: 'html',
		beforeSend: function() {
		    $('.overlay-wrapper').html('<div class="overlay">' +
		    					'<i class="fas fa-3x fa-sync-alt fa-spin"></i>' +
		    					'<div class="text-bold pt-2">Loading...</div>' +
            					'</div>');
		},
		complete: function(){
		    $('.overlay-wrapper').html('');
		},
		success: function(result) {
			$('#service_list').html(result);
		}
	})
}

//Function: Retrieve Service Info
function get_service_info(id){
	$.ajax({
		url: 'service/get_service_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			clear();
			$('#text_name').val(result['name']);
			$('#text_description').val(result['description']);
			$('#text_rate').val(result['rate']);
		}
	})
}

//Function: Change Service Record Status
function toggle_service_status(id, status){
	$.ajax({
		url: 'service/toggle_service_status',
		data: {id: id, status: status},
		method: 'POST',
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				var header, msg;

				if (global_action == 'remove'){
					var header = 'Removed';
					var msg = 'Service record removed!';
				}
				else if (global_action == 'reactivate'){
					var header = 'Reactivated';
					var msg = 'Service record reactivated!';
				}
								
				$('#modal_confirm').modal('toggle');
				$('#modal_body_header').html(header);
				$('#modal_body_message').html(msg);
				$('#modal_message').modal({
					backdrop: 'static',
			    	keyboard: false
				});

				setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
				if (global_action == 'remove'){
					setTimeout(function(){ retrieve_services(1); }, 4000);
				}
				else if (global_action == 'reactivate'){
					setTimeout(function(){ retrieve_services(0); }, 4000);
				}
				
			}
		}
	})
}

//Function: Clear Fields
function clear(){
	$('#text_name').val('');
	$('#text_description').val('');
	$('#text_rate').val('');
}