var global_product_row_ctr = 0;
var global_service_row_ctr = 0;
var global_product_id;
var global_service_id;
var global_remove_action;

get_transaction_id();
date();

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
	$('#text_id').val(id);
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
	var record = [];
	var ctr = 0;
	var row_ctr = 0;
	var item_ctr = 0;
	var subtotal = 0, down_payment = 0, discount = 0, grand_total = 0;
	var patientid = $('#text_id').val();
	var error = false;
	var no_of_rows = $('#table_services_availed tbody tr').length;

	if (patientid.trim() == ''){
		var header = 'Error',
			msg = 'Please provide patient information.';

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
		error = true;
	}
	else if (no_of_rows <= 0){
		var header = 'Error',
			msg = 'No services availed. Please select at least one.';

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
		error = true;
	}

	if (error == false){
		$('#span_date').html($('#text_date').val());
		$('#span_transaction_id').html($('#text_transaction_id').val());
		$('#span_patient_id').html($('#text_patient_id').val());
		$('#span_fullname').html($('#text_fullname').val());
		$('#span_address').html($('#text_address').val());
		$('#span_sex').html($('#text_sex').val());
		$('#span_age').html($('#text_age').val());
		$('#span_contact_number').html($('#text_contact_number').val());

		$('#table_services_availed tbody').find('tr').each(function(){
	      var $this = $(this);
	      var total = parseFloat($('td:eq(5)', $this).text().replace(/,/g, '')) * parseFloat(1);
	      total = formatNumber(total.toFixed(2));
	      record[ctr] = [$('td:eq(0)', $this).text(), ++row_ctr, $('td:eq(2)', $this).text(), 'Service', $('td:eq(5)', $this).text(), '1', total];
	      ctr++;
	      item_ctr++;
	    });

	    $('#table_products_ordered tbody').find('tr').each(function(){
	      var $this = $(this);
	      var total = parseFloat($('td:eq(4)', $this).text().replace(/,/g, '')) * parseFloat($('td:eq(5)', $this).text().replace(/,/g, ''));
	      total = formatNumber(total.toFixed(2));
	      record[ctr] = [$('td:eq(0)', $this).text(), ++row_ctr, $('td:eq(2)', $this).text(), 'Product', $('td:eq(4)', $this).text(), $('td:eq(5)', $this).text(), total];
	      ctr++;
	      item_ctr++;
	    });

	    $('#table_summary tbody').html('');

	    for (var i = 0; i < item_ctr; i++){
			$('#table_summary tbody').append('<tr><td style="display:none">'+ record[i][0] +'</td>'+ 
	    											'<td>'+ record[i][1] +'</td>'+
	    											'<td>'+ record[i][2] +'</td>'+ 
	    											'<td>'+ record[i][3] +'</td>'+ 
	    											'<td>'+ record[i][4] +'</td>'+ 
	    											'<td>'+ record[i][5] +'</td>'+
	    											'<td>'+ record[i][6] +'</td></tr>');

	    }

	    $('#table_summary tbody').find('tr').each(function(){
	      var $this = $(this);
	      subtotal += parseFloat($('td:eq(6)', $this).text().replace(/,/g, ''));
	    });

	    grand_total = subtotal + down_payment + discount;

	    $('#span_sub_total').html(formatNumber(subtotal.toFixed(2)));
	    $('#span_required_dp').html(formatNumber(down_payment.toFixed(2)));
	    $('#span_discount_price').html(formatNumber(discount.toFixed(2)));
	    $('#span_grand_total').html(formatNumber(grand_total.toFixed(2)));

		$('#modal_summary').modal({
			backdrop: 'static',
	    	keyboard: false
		});
	}
});

$('#btn_save_transaction').click(function(){
	var transaction_id = $('#text_transaction_id').val(),
		date = $('#text_date').val(),
		patientid = $('#text_id').val(),
		age = $('#text_age').val(),
		transaction_detail = [],
		ctr = 0;

	$('#table_services_availed tbody').find('tr').each(function(){
      var $this = $(this);
      var total = parseFloat($('td:eq(5)', $this).text().replace(/,/g, '')) * parseFloat(1);
      total = formatNumber(total.toFixed(2));
      transaction_detail[ctr] = [$('td:eq(0)', $this).text(), 'Service', $('td:eq(5)', $this).text(), '1', total];
      ctr++;
    });

    $('#table_products_ordered tbody').find('tr').each(function(){
      var $this = $(this);
      var total = parseFloat($('td:eq(4)', $this).text().replace(/,/g, '')) * parseFloat($('td:eq(5)', $this).text().replace(/,/g, ''));
      total = formatNumber(total.toFixed(2));
      transaction_detail[ctr] = [$('td:eq(0)', $this).text(), 'Product', $('td:eq(4)', $this).text(), $('td:eq(5)', $this).text(), total];
      ctr++;
    });

    insert_transaction(transaction_id, date, patientid, age, transaction_detail);
});

$('#btn_print_bill').click(function(){
	var css = '<link rel="stylesheet" href="public/bootstrap/plugins/fontawesome-free/css/all.min.css">' +
			  '<link rel="stylesheet" href="public/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">' +
			  '<link rel="stylesheet" href="public/bootstrap/dist/css/adminlte.min.css">' +
			  '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">' +
			  '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">' +
			  '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">';
	var html = $('#to_print').html();
	var js = '<script src="public/bootstrap/plugins/jquery/jquery.min.js"></script>' +
				'<script src="public/bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>' +
				'<script src="public/bootstrap/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>' +
				'<script src="public/bootstrap/dist/js/adminlte.js"></script>' +
				'<script src="public/bootstrap/dist/js/demo.js"></script>' +
				'<script src="public/bootstrap/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>' +
				'<script src="public/bootstrap/plugins/raphael/raphael.min.js"></script>' +
				'<script src="public/bootstrap/plugins/jquery-mapael/jquery.mapael.min.js"></script>' +
				'<script src="public/bootstrap/plugins/jquery-mapael/maps/usa_states.min.js"></script>' +
				'<script src="public/bootstrap/plugins/chart.js/Chart.min.js"></script>' +
				'<script src="public/bootstrap/dist/js/pages/dashboard2.js"></script>' +
				'<script src="public/bootstrap/plugins/datatables/jquery.dataTables.min.js"></script>' +
				'<script src="public/bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>' +
				'<script src="public/bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>' +
				'<script src="public/bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>' +
				'<script src="public/bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>';
	var title = 'Patient Billing';
	var params = [
		    'height='+screen.height,
		    'width='+screen.width,
		    'fullscreen=yes' 
		].join(',');
    var mywindow = window.open('', title, params);
    mywindow.document.write(css);
	mywindow.document.write(html);
	mywindow.document.write(js);
	mywindow.document.write('<title>' + title + '</title>');
	setTimeout(function(){ mywindow.print(); }, 1000);
	/*$.ajax({
       url: 'transaction/print_bill',
        method: 'GET',
        data: {print_page: html},
        dataType: 'HTML'
    }).done(function(response) {
    	var title = 'Patient Billing';
    	var params = [
			    'height='+screen.height,
			    'width='+screen.width,
			    'fullscreen=yes' 
			].join(',');
        var mywindow = window.open('', title, params);
		mywindow.document.write(response);
		mywindow.document.write('<title>' + title + '</title>');
		setTimeout(function(){ mywindow.print(); }, 1000);
    })*/
});

function insert_transaction(transaction_id, date, patientid, age, transaction_detail){
	$.ajax({
		url: 'transaction/insert_transaction',
		method: 'POST',
		data: {transaction_id: transaction_id, date: date, patientid: patientid, age: age, transaction_detail: transaction_detail},
		dataType: 'html',
		success: function(result) {

			var msg, header;

			if (result == 1){
				header = 'Saved';
				msg = 'Transaction successfully saved!';
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
				setTimeout(function(){ $('#modal_summary').modal('toggle'); }, 3000);
				clear_all();
				get_transaction_id();
			}
			else{
				header = 'Error';
				msg = 'Error during saving!';
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

			$('.modal').on("hidden.bs.modal", function (e) { 
			    if ($('.modal:visible').length) { 
			            $('body').addClass('modal-open'); 
			    }
			});
		}
	})
}

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
			clear_patient_info();
			var purok = '';
			
			if (!(result['address_purok'].trim() ==''|result['address_purok'].trim() =='0')){
				purok = 'Purok ' + result['address_purok'] + ', ';
			}
			var fullname = result['firstname']+' '+result['middlename']+' '+result['lastname']+' '+result['extension'];
			var address = purok+result['address_brgy']+', '+result['address_citymun']+' Bohol';

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

function date(){
	var today = new Date();
    var day = today.getDate();
    var month = today.getMonth()+1;
    var year = today.getFullYear();
    var formatted_date;

    if (day < 10)
    {
    	day='0'+day;
	}

	if (month < 10)
    {
    	month='0'+month;
	}

	formatted_date = month.toString() + '-' + day.toString() + '-' + year.toString();

	$('#text_date').val(formatted_date);
}

function clear_patient_info(){
	$('#text_patient_id').val('');
	$('#text_fullname').val('');
	$("#text_address").val('');
	$('#text_sex').val('');
	$('#text_contact_number').val('');
	$('#text_email').val('');
	$('#text_birthdate').val('');
	$('#text_age').val('');
}

function clear_all(){
	$('#text_id').val('');
	$('#text_patient_id').val('');
	$('#text_fullname').val('');
	$("#text_address").val('');
	$('#text_sex').val('');
	$('#text_contact_number').val('');
	$('#text_email').val('');
	$('#text_birthdate').val('');
	$('#text_age').val('');
	$("#table_services_availed > tbody").html("");
	$("#table_products_ordered > tbody").html("");
	var global_product_row_ctr = 0;
	var global_service_row_ctr = 0;
	var global_product_id = 0;
	var global_service_id = 0;
	var global_remove_action = '';
}