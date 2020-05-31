var global_id;
var global_action;

retrieve_accessroles(1);

$('#text_role_name').on('change', function() {
	$('#text_role_name').removeClass('is-invalid');
});

$('#text_description').on('change', function() {
	$('#text_description').removeClass('is-invalid');
});

$('#btn_new_role').click(function(){
	clear();
	global_action = 'add';
	$("#modal_accessrole_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('#btn_active').click(function(){
	retrieve_accessroles(1);
})

$('#btn_inactive').click(function(){
	retrieve_accessroles(0);
})

$('body').on('click', '#btn_edit_control', function(){
	global_id = $(this).val();
	global_action = 'edit';
	get_accessrole_info(global_id);
	$("#modal_accessrole_form").modal({
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
	var name = $('#text_role_name').val(),
		description = $('#text_description').val(),
		error = false;

	if (name == ''){
		$('#text_role_name').addClass('is-invalid');
		error = true;
	}

	if (description == ''){
		$('#text_description').addClass('is-invalid');
		error = true;
	}

	if (error == false){
		if (global_action=='edit'){
			insert_accessrole(global_id, name, description);
		}
		else if (global_action=='add'){
			insert_accessrole('', name, description);
		}
		
	}
})

$('#btn_yes').click(function(){
	if (global_action == 'remove'){
		toggle_accessrole_status(global_id, 0);
	}
	else if (global_action == 'reactivate'){
		toggle_accessrole_status(global_id, 1);
	}
})

//Function: Save Role Info
function insert_accessrole(id, name, description){
	$.ajax({
		url: 'accessrole/insert_accessrole',
		method: 'POST',
		data: {id: id, name: name, description: description},
		dataType: 'html',
		success: function(result) {
			var msg, header;

			if (result == 1){
				header = 'Saved';
				msg = 'Role information successfully saved!';
			}
			else if (result == 2){
				header = 'Updated';
				msg = 'Role information successfully updated!';
			}
			
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('#modal_message').modal('show');

			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
			setTimeout(function(){ $('#modal_accessrole_form').modal('toggle'); }, 3000);
			setTimeout(function(){ retrieve_accessroles(1); }, 4000);
			setTimeout(function(){ clear(); }, 4000);
		}
	})
}

//Function: Retrieve All Roles
function retrieve_accessroles(status){
	$.ajax({
		url: 'accessrole/retrieve_accessroles',
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
			$('#accessrole_list').html(result);
		}
	})
}

//Function: Retrieve Role Info
function get_accessrole_info(id){
	$.ajax({
		url: 'accessrole/get_accessrole_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			clear();
			$('#text_role_name').val(result['name']);
			$('#text_description').val(result['description']);
		}
	})
}

//Function: Change Role Record Status
function toggle_accessrole_status(id, status){
	$.ajax({
		url: 'accessrole/toggle_accessrole_status',
		data: {id: id, status: status},
		method: 'POST',
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				var header, msg;

				if (global_action == 'remove'){
					var header = 'Removed';
					var msg = 'Access role record removed!';
				}
				else if (global_action == 'reactivate'){
					var header = 'Reactivated';
					var msg = 'Access role record reactivated!';
				}
								
				$('#modal_confirm').modal('toggle');
				$('#modal_body_header').html(header);
				$('#modal_body_message').html(msg);
				$('#modal_message').modal('show');

				setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
				if (global_action == 'remove'){
					setTimeout(function(){ retrieve_accessroles(1); }, 4000);
				}
				else if (global_action == 'reactivate'){
					setTimeout(function(){ retrieve_accessroles(0); }, 4000);
				}
				
			}
		}
	})
}

//Function: Clear Fields
function clear(){
	$('#text_role_name').val('');
	$('#text_description').val('');
}