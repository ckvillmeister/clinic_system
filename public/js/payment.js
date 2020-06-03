
$('#text_transaction_id').keypress(function(event){
 	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		var transaction_id = $('#text_transaction_id').val();
		get_transaction_detail(transaction_id, 0);
	}
});

$('#btn_search').click(function(){
	var transaction_id = $('#text_transaction_id').val();
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
	$("#modal_transaction_list").modal('toggle');
});

$('#btn_enter_discounted_amount').click(function(){
	var discounted_amount = parseFloat($('#text_discount').val()),
		dp_amount = parseFloat($('#texth_dp').val()),
		total_amount = parseFloat($('#texth_totalamount').val()),
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
		var new_amount = discounted_amount.toFixed(2);
		$('#texth_discount').val(discounted_amount);
		$('#discounted_amount').html(formatNumber(new_amount));
		$('#modal_set_discount').modal('toggle');
	}

});

$('#btn_enter_payment_amount').click(function(){
	var total_amount = parseFloat($('#texth_totalamount').val()),
		balance_amount = parseFloat($('#texth_balance').val()),
		discounted_amount = parseFloat($('#text_discount').val()),
		down_payment_amount = parseFloat($('#texth_dp').val()),
		payment_amount = parseFloat($('#text_amount').val()),
		expr = /^((\+|-)?(0|([1-9][0-9]*))(\.[0-9]+)?)$/;

	if (payment_amount < dp_amount){
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
	}

});

function get_transaction_detail(transaction_id, sys_id){
	$.ajax({
		url: 'payment/get_transaction_detail',
		method: 'POST',
		data: {transaction_id: transaction_id, id: sys_id},
		dataType: 'html',
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