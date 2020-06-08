
$('#text_transaction_id').keypress(function(event){
 	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		var transaction_id = $('#text_transaction_id').val();
		$('#texth_transaction_id').val(transaction_id);
		get_transaction_detail(transaction_id, 0);
	}
});

$('#btn_search').click(function(){
	var transaction_id = $('#text_transaction_id').val();
	$('#texth_transaction_id').val(transaction_id);
	get_transaction_detail(transaction_id, 0);
});

$('#btn_transaction_list').click(function(){
	get_transaction_list(1);
	$("#modal_transaction_list").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('body').on('click', '#btn_select', function(){
	transaction_id = $(this).closest("tr").find('td:eq(1)').text()
	$('#text_transaction_id').val(transaction_id);
	$('#text_transaction_sys_id').val($(this).val());
	get_transaction_detail(transaction_id, $(this).val());
	$('#texth_transaction_id').val(transaction_id);
	$("#modal_transaction_list").modal('toggle');
});

$('#btn_enter_discounted_amount').click(function(){
	var discounted_amount = parseFloat($('#text_discount').val()),
		dp_amount = parseFloat($('#texth_dp').val()),
		total_amount = parseFloat($('#texth_totalamount').val()),
		dp_percent = parseFloat($('#texth_dppercent').val()),
		expr = /^((\+|-)?(0|([1-9][0-9]*))(\.[0-9]+)?)$/;

	if (discounted_amount < dp_amount){
		var header = 'Error',
			msg = 'Please enter discounted amount higher than down payment.';
		
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
	else if (discounted_amount > total_amount){
		var header = 'Error',
			msg = 'Discounted amount is higher than total amount.';
		
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
	else if (!($('#text_discount').val().match(expr))){
		var header = 'Error',
			msg = 'Invalid amount.';
		
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
		var new_dp = dp_percent * discounted_amount;
		var new_amount = discounted_amount.toFixed(2);
		
		$('#balance_amount').html(formatNumber(new_amount));
		$('#discounted_amount').html(formatNumber(new_amount));
		$('#downpayment_amount').html(formatNumber(new_dp.toFixed(2)));

		$('#texth_balance').val(new_amount);
		$('#texth_discount').val(discounted_amount);
		$('#texth_dp').val(new_dp);
		
		$('#modal_set_discount').modal('toggle');
	}

});

$('#btn_enter_payment_amount').click(function(){
	var total_amount = parseFloat($('#texth_totalamount').val()),
		balance_amount = parseFloat($('#texth_balance').val()),
		discounted_amount = parseFloat($('#texth_discount').val()),
		down_payment_amount = parseFloat($('#texth_dp').val()),
		cash_tendered = parseFloat($('#text_amount').val()),
		transaction_sys_id = $('#text_transaction_sys_id').val();
		transaction_id = $('#texth_transaction_id').val();
		expr = /^((\+|-)?(0|([1-9][0-9]*))(\.[0-9]+)?)$/;

	if ((cash_tendered < down_payment_amount) & (total_amount == balance_amount)){
		var header = 'Error',
			msg = 'Please enter payment higher than down payment.';
		
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
	else if (!($('#text_amount').val().match(expr))){
		var header = 'Error',
			msg = 'Invalid amount.';
		
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
		$('#modal_tender_cash').modal('toggle');
		save_payment(transaction_sys_id, total_amount, balance_amount, discounted_amount, cash_tendered, transaction_id);
	}

});

function get_transaction_detail(transaction_id, sys_id){
	$.ajax({
		url: 'payment/get_transaction_detail',
		method: 'POST',
		data: {transaction_id: transaction_id, id: sys_id},
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
			if (result == 0){
				var header = 'Not Found',
					msg = 'Transaction ID not found!';
				
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
				$('#payment_detail').html(result);
			}
		}
	})
}

function save_payment(transaction_sys_id, total_amount, balance_amount, discounted_amount, cash_tendered, transaction_id){
	$.ajax({
		url: 'payment/save_payment',
		method: 'POST',
		data: {transaction_id: transaction_sys_id, total_amount: total_amount, balance_amount: balance_amount, discounted_amount: discounted_amount, cash_tendered: cash_tendered},
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
			if (result == 1){
				var header = 'Saved',
					msg = 'Payment saved!';
				
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
				setTimeout(function(){ $('#transaction_list').empty(); }, 3000);
				setTimeout(function(){ get_transaction_detail(transaction_id, transaction_sys_id); }, 4000);
			}
			else{
				var header = 'Error',
					msg = 'Error during processing payment!';
				
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

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

function get_transaction_list(status){
	$.ajax({
		url: 'payment/get_transaction_list',
		method: 'POST',
		data: {status: status},
		dataType: 'html',
		success: function(result) {
			$('#transaction_list').html(result);
		}
	})
	
}