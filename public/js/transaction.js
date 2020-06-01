var global_product_row_ctr = 0;
var global_service_row_ctr = 0;
var global_product_id;
var global_service_id;
var global_remove_action;

get_transaction_id();

$('#btn_search').click(function(){
	retrieve_patients(1);
	$("#modal_patient_list").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('#cbo_services').on('change', function(){
	$('#text_service_name').val($("#cbo_services :selected").text());
	var id = $("#cbo_services").val();
	get_service_info(id);
	$("#modal_service_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
})

$('#btn_search_product').click(function(){
	retrieve_products(1);
	$("#modal_product_list").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('body').on('click', '#btn_select_patient_control', function(){
	id = $(this).val();
	get_patient_info(id);
	$('#modal_patient_list').modal('toggle');
});

$('body').on('click', '#btn_select_product_control', function(){
	global_product_id = $(this).val();

	$("#modal_quantity").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('#btn_add_product').click(function(){
	var qty = $('#text_number_of_products').val();

	if (isRecordExist(global_product_id, '#table_products_ordered')){
		var header = 'Duplicate',
			msg = 'Product is already added in the list!';
		
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
	else if (!(qty.match(/^\d+/))){
		var header = 'Invalid',
			msg = 'Invalid quantity!';
		
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
	else if(qty == '' | qty == 0){
		var header = 'Invalid',
			msg = 'Invalid quantity!';
		
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
		get_product_info(global_product_id, qty);
		$('#modal_product_list').modal('toggle');
	}
})

$('body').on('click', '#btn_remove_product', function(){
	$('#modal_confirm').modal({
		backdrop: 'static',
    	keyboard: false
	});
	global_product_id = $(this).val();
	global_remove_action = 'product';
	$('#modal_confirm_message').html('Are you sure you want to remove this product?');
});

$('#btn_add_service').click(function(){
	var service_id = $('#cbo_services').val(),
		prescription = $('#text_prescription').val(),
		remarks = $('#text_remarks').val(),
		charge = $('#text_charge').val(),
		service_name = $("#cbo_services :selected").text();

	if (isRecordExist(service_id, '#table_services_availed')){
		$('#table_services_availed').find('tr').each(function(){
		    var $this = $(this);
		    var index = $(this).index();
		    if(service_id == $('td:eq(0)', $this).text()){
		    	$('#table_services_availed tbody tr:eq('+index+')').find('td:eq(3)').text(prescription);
		    	$('#table_services_availed tbody tr:eq('+index+')').find('td:eq(4)').text(remarks);
			}
		});
	}
	else{
		$('#table_services_availed tbody').append('<tr><td style="display:none">'+ service_id +'</td>'+ 
										'<td>'+ ++global_service_row_ctr +'</td>'+
										'<td>'+ service_name +'</td>'+
										'<td>'+ prescription +'</td>'+
										'<td>'+ remarks +'</td>'+
										'<td>'+ charge +'</td>'+
										'<td>'+
										'<button value="' + service_id + '" class="btn btn-sm btn-warning mr-2" id="btn_edit_service" style="width:90px"><i class="fas fa-edit"> Edit</i></button>'+
										'<button value="' + service_id + '" class="btn btn-sm btn-danger" id="btn_remove_service" style="width:90px"><i class="fas fa-trash"> Remove</i></button>'+
										'</td></tr>');
		
	}

	$('#modal_service_form').modal('toggle');
	$('#cbo_services').val('');
	$('#text_prescription').val('');
	$('#text_remarks').val('');
})

$('body').on('click', '#btn_edit_service', function(){
	global_service_id = $(this).val();
	var service_name =  $(this).closest("tr").find('td:eq(2)').text(),
		prescription =  $(this).closest("tr").find('td:eq(3)').text(),
		remarks =  $(this).closest("tr").find('td:eq(4)').text();

	$('#text_service_name').val(service_name);
	$('#text_prescription').val(prescription);
	$('#text_remarks').val(remarks);

	$("#modal_service_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('body').on('click', '#btn_remove_service', function(){
	$('#modal_confirm').modal({
		backdrop: 'static',
    	keyboard: false
	});
	global_product_id = $(this).val();
	global_remove_action = 'service';
	$('#modal_confirm_message').html('Are you sure you want to remove this service?');
});

$('#btn_yes').click(function(){
	var i = 0;

	if (global_remove_action == 'product'){
		$('#table_products_ordered tbody').find('tr').each(function(){
			var col = $(this).closest("tr").find('td:eq(0)').text();
			
			if (col == global_product_id){
				$("#table_products_ordered tbody tr:eq("+i+")").remove();
			}
			i++;
		});
		
		var no = 1;
	    $('#table_products_ordered tbody').find('tr').each(function(){
	        var $this = $(this);
	        $('td:eq(1)', $this).text(no);
	        no++;
	    });
	    global_product_row_ctr--;
	}
	else if (global_remove_action == 'service'){
		$('#table_services_availed tbody').find('tr').each(function(){
			var col = $(this).closest("tr").find('td:eq(0)').text();
			
			if (col == global_product_id){
				$("#table_services_availed tbody tr:eq("+i+")").remove();
			}
			i++;
		});
		
		var no = 1;
	    $('#table_services_availed tbody').find('tr').each(function(){
	        var $this = $(this);
	        $('td:eq(1)', $this).text(no);
	        no++;
	    });
	    global_service_row_ctr--;
	}

    $('#modal_confirm').modal('toggle');
})

$('#btn_confirm').click(function(){
	$('#modal_summary').modal({
		backdrop: 'static',
    	keyboard: false
	});
});

//Function: Get Latest Transaction ID
function get_transaction_id(){
	$.ajax({
		url: 'transaction/get_transaction_id',
		method: 'POST',
		dataType: 'html',
		success: function(result) {
			$('#text_transaction_id').val(result);
		}
	})
}

//Function: Retrieve All Patients
function retrieve_patients(status){
	$.ajax({
		url: 'transaction/retrieve_patients',
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

//Function: Retrieve All Patients
function get_patient_info(id){
	$.ajax({
		url: 'transaction/get_patient_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			clear();
			var purok;
			if (!(result['address_purok']==''|result['address_purok']=='0')){
				purok = 'Purok ' + result['address_purok'];
			}
			var fullname = result['firstname']+' '+result['middlename']+' '+result['lastname']+' '+result['extension'];
			var address = purok+', '+result['address_brgy']+', '+result['address_citymun']+' Bohol';

			$('#text_patient_id').val(result['patientid']);
			$('#text_fullname').val(fullname.toUpperCase());
			$("#text_address").val(address.toUpperCase());
			$('#text_sex').val(result['sex'].toUpperCase());
			$('#text_contact_number').val(result['contact_number'].toUpperCase());
			$('#text_email').val(result['email']);
			
			var birthdate = result['birthdate'].toString();
			
			if(birthdate != '0000-00-00'){
				$('#text_birthdate').val(result['birthdate'].toUpperCase());
				calculate_age(birthdate);
			}
		}
	})
}

//Function: Retrieve All Products
function retrieve_products(status){
	$.ajax({
		url: 'transaction/retrieve_products',
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
			$('#product_list').html(result);
		}
	})
}

//Function: Retrieve Product Info
function get_product_info(id, qty){
	$.ajax({
		url: 'transaction/get_product_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			var price = formatNumber(result['price'].toFixed(2));
			var	total = result['price'] * qty;
			$('#table_products_ordered tbody').append('<tr><td style="display:none">'+result['id']+'</td>' + 
										'<td>'+ ++global_product_row_ctr +'</td>'+
										'<td>'+result['name']+'</td>'+
										'<td>'+result['description']+'</td>'+
										'<td>'+ price +'</td>'+
										'<td>'+ qty +'</td>'+
										'<td>'+ formatNumber(total.toFixed(2)) +'</td>'+
										'<td><button type="button" value="' + id + '" class="btn btn-sm btn-danger" id="btn_remove_product" data-toggle="tooltip" data-placement="top" title="Remove Product"><i class="fas fa-trash"> Remove</i></button></td></tr>');
			$('#modal_quantity').modal('toggle');
			$('#text_number_of_products').val('');
		}
	})
}

//Function: Retrieve Service Info
function get_service_info(id, qty){
	$.ajax({
		url: 'transaction/get_service_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			var rate = formatNumber(result['rate'].toFixed(2));
			$('#text_charge').val(rate);
		}
	})
}

//Function: Check if Exist
function isRecordExist(id, table){
	var flag = false;

	$(table).find('tr').each(function(){
	    var $this = $(this);
	    if(id == $('td:eq(0)', $this).text()){
	        flag = true;
	    }
	});

	if(flag){
	  return true;
	}
	else{
	  return false;
	}
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

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

function clear(){
	$('#text_patient_id').val('');
	$('#text_fullname').val('');
	$("#text_address").val('');
	$('#text_sex').val('');
	$('#text_contact_number').val('');
	$('#text_email').val('');
	$('#text_birthdate').val('');
	$('#text_age').val('');
}