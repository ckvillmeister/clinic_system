$('#transaction_text_year_from').on('change', function(){
	$('#transaction_text_year_from').removeClass('is-invalid');
});

$('#transaction_text_year_to').on('change', function(){
	$('#transaction_text_year_to').removeClass('is-invalid');
});

$('#transaction_btn_generate').click(function(){
	
	var status = $('#transaction_cbo_status').val(),
		services = $('#transaction_cbo_services').val(),
		months = $('#transaction_cbo_months').val(),
		from = $('#transaction_text_year_from').val(),
		to = $('#transaction_text_year_to').val(),
		error = false;

	if (from == '' & to != ''){
		$('#transaction_text_year_from').addClass('is-invalid');
		error = true;
	}

	if (from != '' & to == ''){
		$('#transaction_text_year_to').addClass('is-invalid');
		error = true;
	}

	if (from > to){
		$('#transaction_text_year_to').addClass('is-invalid');
		error = true;
	}

	if (error != true){
		transaction_report(status, services, months, from, to);
	}
});

$('#patient_btn_generate').click(function(){
	var filter = $('#patient_cbo_filter').val();

	patient_report(filter);
});

$('#product_btn_generate').click(function(){
	var filter = $('#product_cbo_filter').val();

	product_report(filter);
});

$('#collection_btn_generate').click(function(){
	var month = $('#collection_cbo_months').val(),
		year = $('#collection_text_year').val();

	collection_report(month, year);
});

//Function: Transaction Report
function transaction_report(status, services, months, from, to){
	$.ajax({
		url: 'report/transaction_report',
		method: 'POST',
		data: {status: status, services: services, months: months, from: from, to: to},
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
			$('#transaction_list').html(result);
		}
	})
}

//Function: Patients Report
function patient_report(filter){
	$.ajax({
		url: 'report/patient_report',
		method: 'POST',
		data: {filter: filter},
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

//Function: Products Report
function product_report(filter){
	$.ajax({
		url: 'report/product_report',
		method: 'POST',
		data: {filter: filter},
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
			$('#product_list').html(result);
		}
	})
}

//Function: Collection Report
function collection_report(month, year){
	$.ajax({
		url: 'report/collection_report',
		method: 'POST',
		data: {month: month, year: year},
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
			$('#collection_list').html(result);
		}
	})
}