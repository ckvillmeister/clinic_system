var global_id;
var global_action;

retrieve_patients(1);

$('#text_firstname').on('change', function() {
	$('#text_firstname').removeClass('is-invalid');
});

$('#text_lastname').on('change', function() {
	$('#text_lastname').removeClass('is-invalid');
});

$('#text_birthdate').on('change', function() {
	var birthdate = $("#text_birthdate").val().toString();
	calculate_age(birthdate);
});

$('#btn_new_patient').click(function(){
	clear();
	$("#modal_patient_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
	get_patient_id();
});

$('#btn_active').click(function(){
	retrieve_patients(1);
})

$('#btn_inactive').click(function(){
	retrieve_patients(0);
})

$('body').on('click', '#btn_edit_control', function(){
	var id = $(this).val();
	get_patient_info(id);
	$("#modal_patient_form").modal({
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

$('#cbo_muncity').on('change', function() {
	var mun_city_code = $('#cbo_muncity').val();

	if (mun_city_code != 0) {
		retrieve_barangays(mun_city_code);
	}
});

$('#btn_submit').click(function(){
	var patient_id = $('#text_patient_id').val(),
		firstname = $('#text_firstname').val(),
		middlename = $('#text_middlename').val(),
		lastname = $('#text_lastname').val(),
		extension = $('#cbo_extension').val(),
		addr_citymun = $('#cbo_muncity').val(),
		addr_barangay = $('#cbo_brgy').val(),
		addr_purok = $('#cbo_purok').val(),
		sex = $('#cbo_sex').val(),
		birthdate = $('#text_birthdate').val(),
		number = $('#text_number').val(),
		email = $('#text_email').val(),
		error = false;

	if (firstname == ''){
		$('#text_firstname').addClass('is-invalid');
		error = true;
	}

	if (lastname == ''){
		$('#text_lastname').addClass('is-invalid');
		error = true
	}

	if (error == false){
		insert_patient(patient_id, firstname, middlename, lastname, extension, addr_citymun, addr_barangay, addr_purok, sex, birthdate, number, email);
	}
})

$('#btn_yes').click(function(){
	if (global_action == 'remove'){
		toggle_patient_status(global_id, 0);
	}
	else if (global_action == 'reactivate'){
		toggle_patient_status(global_id, 1);
	}
})

//Function: Save Patient Info
function insert_patient(patient_id, firstname, middlename, lastname, extension, addr_citymun, addr_barangay, addr_purok, sex, birthdate, number, email){
	$.ajax({
		url: 'patient/insert_patient',
		method: 'POST',
		data: {patient_id:patient_id, firstname:firstname, middlename:middlename, lastname:lastname, extension:extension, addr_citymun:addr_citymun, addr_barangay:addr_barangay, addr_purok:addr_purok, sex:sex, birthdate:birthdate, number:number, email:email},
		dataType: 'html',
		success: function(result) {
			var msg, header;

			if (result == 1){
				header = 'Saved';
				msg = 'Patient information successfully saved!';
			}
			else if (result == 2){
				header = 'Updated';
				msg = 'Patient information successfully updated!';
			}
			
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('#modal_message').modal('show');

			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
			setTimeout(function(){ $('#modal_patient_form').modal('toggle'); }, 3000);
			setTimeout(function(){ retrieve_patients(1); }, 4000);
			setTimeout(function(){ clear(); }, 4000);
		}
	})
}

//Function: Get Barangay List
function retrieve_barangays(code){
	$.ajax({
		url: 'patient/retrieve_barangays',
		method: 'POST',
		data: {code: code},
		dataType: 'html',
		success: function(result) {
			$('#cbo_brgy').html(result);
		}
	})
}

//Function: Get Latest Patient ID
function get_patient_id(){
	$.ajax({
		url: 'patient/get_patient_id',
		method: 'POST',
		dataType: 'html',
		success: function(result) {
			$('#text_patient_id').val(result);
		}
	})
}

//Function: Retrieve All Patients
function retrieve_patients(status){
	$.ajax({
		url: 'patient/retrieve_patients',
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
			$('#patient_list').html(result);
		}
	})
}

//Function: Retrieve Patient Information
function get_patient_info(id){
	$.ajax({
		url: 'patient/get_patient_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			clear();
			$('#text_patient_id').val(result['patientid']);
			$('#text_firstname').val(result['firstname']);
			$('#text_middlename').val(result['middlename']);
			$('#text_lastname').val(result['lastname']);
			$('#cbo_extension').val(result['extension']);
			$('#cbo_purok').val(result['address_purok']);
			$('#cbo_sex').val(result['sex']);
			$('#text_birthdate').val(result['birthdate']);
			$('#text_number').val(result['contact_number']);
			$('#text_email').val(result['email']);
			$("#cbo_muncity option[value=" + result['address_citymun_id'] + "]").prop("selected",true);
			$('#cbo_muncity').change();
			setTimeout(function(){ $("#cbo_brgy option[value=" + result['address_brgy_id'] + "]").prop("selected",true); }, 500);
			var birthdate = result['birthdate'].toString();

			if(birthdate != '0000-00-00'){
				calculate_age(birthdate);
			}
		}
	})
}

//Function: Change Patient Record Status
function toggle_patient_status(id, status){
	$.ajax({
		url: 'patient/toggle_patient_status',
		data: {id: id, status: status},
		method: 'POST',
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				var header, msg;

				if (global_action == 'remove'){
					var header = 'Removed';
					var msg = 'Patient record removed!';
				}
				else if (global_action == 'reactivate'){
					var header = 'Reactivated';
					var msg = 'Patient record reactivated!';
				}
								
				$('#modal_confirm').modal('toggle');
				$('#modal_body_header').html(header);
				$('#modal_body_message').html(msg);
				$('#modal_message').modal('show');

				setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
				if (global_action == 'remove'){
					setTimeout(function(){ retrieve_patients(1); }, 4000);
				}
				else if (global_action == 'reactivate'){
					setTimeout(function(){ retrieve_patients(0); }, 4000);
				}
				
			}
		}
	})
}

//Function: Calculate Age
function calculate_age(date){
    var mdate = date;
    var yearThen = parseInt(mdate.substring(0,4), 10);
    var monthThen = parseInt(mdate.substring(5,7), 10);
    var dayThen = parseInt(mdate.substring(8,10), 10);
    
    var today = new Date();
    var birthday = new Date(yearThen, monthThen-1, dayThen);
    
    var differenceInMilisecond = today.valueOf() - birthday.valueOf();
    
    var year_age = Math.floor(differenceInMilisecond / 31536000000);
    var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
    var month_age = Math.floor(day_age/30);
    
    day_age = day_age % 30;
     
    if (!(isNaN(year_age) || isNaN(month_age) || isNaN(day_age))) {
         $("#text_age").val(year_age);
    }
}

//Function: Clear Fields
function clear(){
	$('#text_firstname').val('');
	$('#text_middlename').val('');
	$('#text_lastname').val('');
	$('#cbo_extension').val('');
	$('#cbo_muncity').val('');
	$('#cbo_brgy').val('');
	$('#cbo_purok').val('');
	$('#cbo_sex').val('');
	$('#text_birthdate').val('');
	$('#text_number').val('');
	$('#text_email').val('');
	$('#text_age').val('');
}
