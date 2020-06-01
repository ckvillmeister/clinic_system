$(document).ready(function(){

	$('#text_username').focus();

	$('#btn_login').click(function(e){
		var username = $('#text_username').val(),
			password = $('#text_password').val(),
			error = false,
			msg,
			header;


		if (username == ''){
			header = 'Blank Username';
			msg = 'Please enter a username!';
			$('.message_modal_header').removeClass('bg-success');
			$('.message_modal_header').addClass('bg-danger');
			$('.message_icon').removeClass('fas fa-check');
			$('.message_icon').addClass('fas fa-times');
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('#modal_message').modal({
				backdrop: 'static',
		    	keyboard: false
			});
			error = true;
			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 4000);
		}
		else if(password == ''){
			header = 'Blank Password';
			msg = 'Please enter a password!';
			$('.message_modal_header').removeClass('bg-success');
			$('.message_modal_header').addClass('bg-danger');
			$('.message_icon').removeClass('fas fa-check');
			$('.message_icon').addClass('fas fa-times');
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('#modal_message').modal({
				backdrop: 'static',
		    	keyboard: false
			});
			error = true;
			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 4000);
		}
		
		if (error == false){
			login();
		}
	});

	$('#text_password').keypress(function(event){
     	var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			login();
		}
    });

	function login(){
		$.ajax({
		    url: 'authentication/validate_login',
	        method: 'POST',
	        data: {username: $('#text_username').val(), password: $('#text_password').val()},
	        dataType: 'JSON',
	    	success: function(result) {
	    		var msg, header;

				if (result == 1){
					header = 'Login Success';
					msg = 'Login Successful!';
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
					setTimeout(function(){ window.location = 'main';}, 4000);
				}
				else if (result == 2){
					header = 'Login Error';
					msg = 'Invalid username!';
					$('.message_modal_header').removeClass('bg-success');
					$('.message_modal_header').addClass('bg-danger');
					$('.message_icon').removeClass('fas fa-check');
					$('.message_icon').addClass('fas fa-times');
					$('#modal_body_header').html(header);
					$('#modal_body_message').html(msg);
					$('#modal_message').modal({
						backdrop: 'static',
				    	keyboard: false
					});
					setTimeout(function(){ $('#modal_message').modal('toggle'); }, 4000);
				}
				else if (result == 3){
					header = 'Login Error';
					msg = 'Incorrect password!';
					$('.message_modal_header').removeClass('bg-success');
					$('.message_modal_header').addClass('bg-danger');
					$('.message_icon').removeClass('fas fa-check');
					$('.message_icon').addClass('fas fa-times');
					$('#modal_body_header').html(header);
					$('#modal_body_message').html(msg);
					$('#modal_message').modal({
						backdrop: 'static',
				    	keyboard: false
					});
					setTimeout(function(){ $('#modal_message').modal('toggle'); }, 4000);
				}

		    }
		})
	}
});