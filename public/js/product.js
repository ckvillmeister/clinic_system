var global_id;
var global_action;

retrieve_products(1);

$('#text_name').on('change', function() {
	$('#text_name').removeClass('is-invalid');
});

$('#text_price').on('change', function() {
	$('#text_price').removeClass('is-invalid');
});

$('#text_quantity').on('change', function() {
	$('#text_quantity').removeClass('is-invalid');
});

$('#text_reorder').on('change', function() {
	$('#text_reorder').removeClass('is-invalid');
});

$('#btn_new_product').click(function(){
	clear();
	global_action = 'add';
	$("#modal_product_form").modal({
		backdrop: 'static',
    	keyboard: false
	});
});

$('#btn_active').click(function(){
	retrieve_products(1);
})

$('#btn_inactive').click(function(){
	retrieve_products(0);
})

$('body').on('click', '#btn_edit_control', function(){
	global_id = $(this).val();
	global_action = 'edit';
	get_product_info(global_id);
	$("#modal_product_form").modal({
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

$('#btn_submit').click(function(){
	var name = $('#text_name').val(),
		description = $('#text_description').val(),
		uom = $('#text_uom').val(),
		price = $('#text_price').val(),
		quantity = $('#text_quantity').val(),
		reorder = $('#text_reorder').val(),
		error = false;

	if (name == ''){
		$('#text_name').addClass('is-invalid');
		error = true;
	}

	if (price == '' | !(price.match(/^((\+|-)?(0|([1-9][0-9]*))(\.[0-9]+)?)$/))){
		$('#text_price').addClass('is-invalid');
		error = true;
	}

	if (quantity == '' | !(quantity.match(/^\d+$/))){
		$('#text_quantity').addClass('is-invalid');
		error = true;
	}

	if (!(reorder.match(/^\d+$/))){
		$('#text_reorder').addClass('is-invalid');
		error = true;
	}

	if (error == false){
		if (global_action=='edit'){
			insert_product(global_id, name, description, uom, price, quantity, reorder);
		}
		else if (global_action=='add'){
			insert_product('', name, description, uom, price, quantity, reorder);
		}
		
	}
})

$('#btn_yes').click(function(){
	if (global_action == 'remove'){
		toggle_product_status(global_id, 0);
	}
	else if (global_action == 'reactivate'){
		toggle_product_status(global_id, 1);
	}
})

//Function: Save Product Info
function insert_product(id, name, description, uom, price, quantity, reorder){
	$.ajax({
		url: 'product/insert_product',
		method: 'POST',
		data: {id: id, name: name, description: description, uom: uom, price: price, quantity: quantity, reorder: reorder},
		dataType: 'html',
		success: function(result) {
			var msg, header;

			if (result == 1){
				header = 'Saved';
				msg = 'Product information successfully saved!';
			}
			else if (result == 2){
				header = 'Updated';
				msg = 'Product information successfully updated!';
			}
			
			$('#modal_body_header').html(header);
			$('#modal_body_message').html(msg);
			$('#modal_message').modal({
				backdrop: 'static',
		    	keyboard: false
			});

			setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
			setTimeout(function(){ $('#modal_product_form').modal('toggle'); }, 3000);
			setTimeout(function(){ retrieve_products(1); }, 4000);
			setTimeout(function(){ clear(); }, 4000);
		}
	})
}

//Function: Retrieve All Products
function retrieve_products(status){
	$.ajax({
		url: 'product/retrieve_products',
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
function get_product_info(id){
	$.ajax({
		url: 'product/get_product_info',
		method: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function(result) {
			clear();
			$('#text_name').val(result['name']);
			$('#text_description').val(result['description']);
			$('#text_uom').val(result['uom']);
			$('#text_price').val(result['price']);
			$('#text_quantity').val(result['quantity']);
			$('#text_reorder').val(result['reorder']);
		}
	})
}

//Function: Change Product Record Status
function toggle_product_status(id, status){
	$.ajax({
		url: 'product/toggle_product_status',
		data: {id: id, status: status},
		method: 'POST',
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				var header, msg;

				if (global_action == 'remove'){
					var header = 'Removed';
					var msg = 'Product record removed!';
				}
				else if (global_action == 'reactivate'){
					var header = 'Reactivated';
					var msg = 'Product record reactivated!';
				}
								
				$('#modal_confirm').modal('toggle');
				$('#modal_body_header').html(header);
				$('#modal_body_message').html(msg);
				$('#modal_message').modal({
					backdrop: 'static',
			    	keyboard: false
				});

				setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
				if (global_action == 'remove'){
					setTimeout(function(){ retrieve_products(1); }, 4000);
				}
				else if (global_action == 'reactivate'){
					setTimeout(function(){ retrieve_products(0); }, 4000);
				}
				
			}
		}
	})
}

//Function: Clear Fields
function clear(){
	$('#text_name').val('');
	$('#text_description').val('');
	$('#text_uom').val('');
	$('#text_price').val('');
	$('#text_quantity').val('');
	$('#text_reorder').val('');
}