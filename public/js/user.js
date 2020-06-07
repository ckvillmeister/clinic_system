var global_id;
var global_action;

retrieve_users(1);

$('#text_username').on('change', function() {
	$('#text_username').removeClass('is-invalid');
});

$('#text_password').on('change', function() {
	$('#text_password').removeClass('is-invalid');
});

$('#text_firstname').on('change', function() {
	$('#text_firstname').removeClass('is-invalid');
});

$('#text_lastname').on('change', function() {
	$('#text_lastname').removeClass('is-invalid');
});

$('#cbo_accessroles').on('change', function() {
	$('#cbo_accessroles').removeClass('is-invalid');
});

$('#btn_new_user').click(function(){
	$('#text_password').prop('disabled', false);
	clear();
	global_action = 'add';
	$("#modal_user_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('#btn_active').click(function(){
	retrieve_users(1);
})

$('#btn_inactive').click(function(){
	retrieve_users(0);
})

$('body').on('click', '#btn_edit_control', function(){
	$('#text_password').prop('disabled', true);
	global_id = $(this).val();
	global_action = 'edit';
	get_user_info(global_id);
	$("#modal_user_form").modal({
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
	var username = $('#text_username').val(),
		password = $('#text_password').val(),
		firstname = $('#text_firstname').val(),
		middlename = $('#text_middlename').val(),
		lastname = $('#text_lastname').val(),
		extension = $('#cbo_extension').val(),
		role = $('#cbo_accessroles').val(),
		error = false;

	if (username == ''){
		$('#text_username').addClass('is-invalid');
		error = true;
	}

	if (password == '' & global_action=='add'){
		$('#text_password').addClass('is-invalid');
		error = true;
	}

	if (firstname == ''){
		$('#text_firstname').addClass('is-invalid');
		error = true;
	}

	if (lastname == ''){
		$('#text_lastname').addClass('is-invalid');
		error = true;
	}

	if (role == ''){
		$('#cbo_accessroles').addClass('is-invalid');
		error = true;
	}

	if (error == false){
		if (global_action=='edit'){
			insert_user(global_id, username, password, firstname, middlename, lastname, extension, role);
		}
		else if (global_action=='add'){
			insert_user('', username, password, firstname, middlename, lastname, extension, role);
		}
		
	}
})

$('#btn_yes').click(function(){
	if (global_action == 'remove'){
		toggle_user_status(global_id, 0);
	}
	else if (global_action == 'reactivate'){
		toggle_user_status(global_id, 1);
	}
})

//Function: Save User Info
function insert_user(id, username, password, firstname, middlename, lastname, extension, role){
	$.ajax({
		url: 'user/insert_user',
		method: 'POST',
		data: {id: id, username: username, password: password, firstname: firstname, middlename: middlename, lastname: lastname, extension: extension, role: role},
		dataType: 'html',
		success: function(result) {
			var msg, header;

			if (result == 1){
				header = 'Saved';
				msg = 'User account successfully saved!';
			}
			else if (result == 2){
				header = 'Updated';
				msg = 'User account successfully updated!';
			}
			
			$('.message_modal_header').removeClass('bg-danger');
			$('.message_modal_header').addClass('bg-success');
			$('.message_icon').removeClass('fas fa-times');
			$('.message_icon').addClass('fas fa-check');
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('#modal_message').modal({
				backdrop: 'static',
		    	keyboard: false
			});

			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
			setTimeout(function(){ $('#modal_user_form').modal('toggle'); }, 3000);
			setTimeout(function(){ retrieve_users(1); }, 4000);
			setTimeout(function(){ clear(); }, 4000);
		}
	})
}

//Function: Retrieve All Users
function retrieve_users(status){
	$.ajax({
		url: 'user/retrieve_users',
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
			$('#user_list').html(result);
		}
	})
}

//Function: Retrieve User Info
function get_user_info(id){
	$.ajax({
		url: 'user/get_user_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			clear();
			$('#text_username').val(result['username']);
			$('#text_firstname').val(result['firstname']);
			$('#text_middlename').val(result['middlename']);
			$('#text_lastname').val(result['lastname']);
			$('#cbo_extension').val(result['extension']);
			$('#text_firstname').val(result['firstname']);
			$('#cbo_accessroles').val(result['role_type']);
		}
	})
}

//Function: Change User Record Status
function toggle_user_status(id, status){
	$.ajax({
		url: 'user/toggle_user_status',
		data: {id: id, status: status},
		method: 'POST',
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				var header, msg;

				if (global_action == 'remove'){
					var header = 'Removed';
					var msg = 'User account removed!';
				}
				else if (global_action == 'reactivate'){
					var header = 'Reactivated';
					var msg = 'User account reactivated!';
				}
								
				$('#modal_confirm').modal('toggle');
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
				if (global_action == 'remove'){
					setTimeout(function(){ retrieve_users(1); }, 4000);
				}
				else if (global_action == 'reactivate'){
					setTimeout(function(){ retrieve_users(0); }, 4000);
				}
				
			}
			else if(result==2){
				var header = 'Error';
				var msg = 'Unable to deactivate user account. No other user account with an administrator role.';
								
				$('#modal_confirm').modal('toggle');
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
		}
	})
}

//Function: Clear Fields
function clear(){
	$('#text_username').val('');
	$('#text_password').val('');
	$('#text_firstname').val('');
	$('#text_middlename').val('');
	$('#text_lastname').val('');
	$('#cbo_extension').val('');
	$('#text_firstname').val('');
	$('#cbo_accessroles').val('');
}

$('#btn_change_pass').click(function(){
	var old_password = $('#text_old_password').val(),
		new_password = $('#text_new_password').val(),
		confirm_password = $('#text_confirm_password').val(),
		error = false;

	if (old_password == ''){
		$('#text_old_password').addClass('is-invalid');
		error = true;
	}

	if (new_password == ''){
		$('#text_new_password').addClass('is-invalid');
		error = true;
	}

	if (confirm_password == ''){
		$('#text_confirm_password').addClass('is-invalid');
		error = true;
	}

	if (confirm_password != new_password){
		$('#text_new_password').addClass('is-invalid');
		$('#text_confirm_password').addClass('is-invalid');
		error = true;
	}

	if (error == false){
		change_password(old_password, new_password, confirm_password);
	}
})

$('#btn_reset_pass').click(function(){
	var new_password = $('#text_reset_new_password').val(),
		confirm_password = $('#text_reset_confirm_password').val(),
		error = false;

	if (new_password == ''){
		$('#text_reset_new_password').addClass('is-invalid');
		error = true;
	}

	if (confirm_password == ''){
		$('#text_reset_confirm_password').addClass('is-invalid');
		error = true;
	}

	if (confirm_password != new_password){
		$('#text_reset_new_password').addClass('is-invalid');
		$('#text_reset_confirm_password').addClass('is-invalid');
		error = true;
	}

	if (error == false){
		reset_password(new_password, confirm_password);
	}
})

function change_password(old_password, new_password, confirm_password){
	$.ajax({
		url: 'change_password',
		method: 'POST',
		data: {old_password: old_password, new_password: new_password, confirm_password: confirm_password},
		dataType: 'json',
		success: function(result) {
			if (result == 1){
				var header = 'Change Password',
					msg = 'Password successfully changed!';
				
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
			else if (result == 0){
				var header = 'Incorrect',
					msg = 'Old password is incorrect!';
				
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
				var header = 'Error',
					msg = 'Error during processing!';
				
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
		}
	})
}

function reset_password(new_password, confirm_password){
	$.ajax({
		url: 'reset_password',
		method: 'POST',
		data: {new_password: new_password, confirm_password: confirm_password},
		dataType: 'json',
		success: function(result) {
			if (result == 1){
				var header = 'Reset Password',
					msg = 'Password reset successful!';
				
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
			else{
				var header = 'Error',
					msg = 'Error during processing!';
				
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
		}
	})
}