var dt_patient_list = $('#table_patient_list').DataTable({
					        "ordering": false,
					        "pageLength": 10,
					        "deferRender": true,
					        "responsive": true,
					        "scrollY": true,
					    });

$('#text_firstname').on('change', function() {
	$('#text_firstname').removeClass('is-invalid');
});

$('#text_lastname').on('change', function() {
	$('#text_lastname').removeClass('is-invalid');
});

$('#btn_new_patient').click(function(){
	$("#modal_patient_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
	get_patient_id();
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
		email = $('#text_email').val();

	if (firstname == ''){
		$('#text_firstname').addClass('is-invalid');
	}

	if (lastname == ''){
		$('#text_lastname').addClass('is-invalid');
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
