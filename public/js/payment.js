
$('#text_transaction_id').keypress(function(event){
 	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		var transaction_id = $('#text_transaction_id').val();
		get_transaction_detail(transaction_id);
	}
});

$('#btn_search').click(function(){
	var transaction_id = $('#text_transaction_id').val();
	get_transaction_detail(transaction_id);
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
	get_transaction_detail(transaction_id);
	$("#modal_transaction_list").modal('toggle');
});

function get_transaction_detail(transaction_id){
	$.ajax({
		url: 'payment/get_transaction_detail',
		method: 'POST',
		data: {transaction_id: transaction_id},
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