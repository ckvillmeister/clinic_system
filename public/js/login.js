$(document).ready(function(){

	$('#text_username').focus();

	$('#btn_login').click(function(e){
		var username = $('#text_username').val(),
			password = $('#text_password').val(),
			error = false;

		if (username == ''){
			$('#username_error_msg').html("<span id='username_message' class='mb-5 text-danger'>Please enter a username!</span>");
			error = true;
		}
		else{
			$('#username_message').fadeOut();
		}

		if(password == ''){
			$('#password_error_msg').html("<span id='password_message' class='mb-5 text-danger'>Please enter a password!</span>");
			error = true;
		}
		else{
			$('#password_message').fadeOut();
		}
		
		if (error == false){
			login();
		}

		setTimeout(function(){ $('#username_message').fadeOut(3000);}, 4000);
		setTimeout(function(){ $('#password_message').fadeOut(3000);}, 4000);
	});

	//$('#text_password').keypress(function(event){
    // 	var keycode = (event.keyCode ? event.keyCode : event.which);
	//	if(keycode == '13'){
	//		login();
	//	}
    //});

	function login(){
		$.ajax({
		    url: 'login/validate_login',
	        method: 'POST',
	        data: {username: $('#text_username').val(), password: $('#text_password').val()},
	        dataType: 'JSON',
	    	success: function(result) {
	    		if (result == 1){
	    			$('#modal_message_box').modal('show');
	    			$('#modal_body').html('Login Successful!');
		    		setTimeout(function(){ window.location = 'main';}, 4000);
		    	}
		    	else if (result == 2){
		    		$('#username_error_msg').html("<span id='username_message' class='mb-5 text-danger'>Invalid username!</span>");
		    		setTimeout(function(){ $('#username_message').fadeOut(3000);}, 4000);
		    	}
		    	else if (result == 3){
		    		$('#password_error_msg').html("<span id='password_message' class='mb-5 text-danger'>Incorrect password!</span>");
		    		setTimeout(function(){ $('#password_message').fadeOut(3000);}, 4000);
		    	}
		    }
		})
	}
});