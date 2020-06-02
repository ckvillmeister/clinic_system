<?php

class paymentController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'payment/index.php', 'system_name' => $this->system_name()));
	}

	public function get_transaction_detail(){
		$transaction_id = $_POST['transaction_id'];

		$payment_obj = new paymentModel();
		$trans_info = $payment_obj->get_transaction_info($transaction_id);
		
		if ($trans_info == 0){
			echo $trans_info;
		}
		else{
			$id = $trans_info['id'];
			$trans_detail = $payment_obj->get_transaction_detail($id);
			$this->view()->render('payment/payment_detail.php', array('trans_info' => $trans_info, 'trans_detail' => $trans_detail));
		}
	}

	public function get_transaction_list(){
		$status = $_POST['status'];
		$payment_obj = new paymentModel();
		$transactions = $payment_obj->get_transaction_list($status);
		$this->view()->render('payment/transaction_list.php', array('transactions' => $transactions));
	}
}
?>