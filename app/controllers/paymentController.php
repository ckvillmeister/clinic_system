<?php

class paymentController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'payment/index.php', 'system_name' => $this->system_name()));
	}

	public function get_transaction_detail(){
		$trans_sys_id = $_POST['id'];
		$transaction_id = $_POST['transaction_id'];

		$payment_obj = new paymentModel();
		$trans_info = $payment_obj->get_transaction_info($transaction_id);
		
		if ($trans_info == 0){
			echo $trans_info;
		}
		else{
			//Transaction Details
			$id = $trans_info['id'];
			$trans_detail = $payment_obj->get_transaction_detail($id);

			//Downpayment Percentage
			$discount_percent = $this->get_dp_percentage();

			//Collection Info
			$collection_info = $this->get_collection_info($trans_sys_id);
			$collection_id = $collection_info['id'];

			//Collection Details
			$collection_detail = $this->get_collection_detail($collection_id);
			

			$this->view()->render('payment/payment_detail.php', array('trans_info' => $trans_info, 'trans_detail' => $trans_detail, 'discount_percent' => $discount_percent, 'collection_info' => $collection_info, 'collection_detail' => $collection_detail));
		}
	}

	public function get_transaction_list(){
		$status = $_POST['status'];
		$payment_obj = new paymentModel();
		$transactions = $payment_obj->get_transaction_list($status);


		$this->view()->render('payment/transaction_list.php', array('transactions' => $transactions));
	}

	public function get_dp_percentage(){
		$discount_percent;
		$settings_obj = new settingsModel();
		$settings = $settings_obj->retrieve_settings();
		
		foreach ($settings as $key => $setting) {
			$setting_detail = (object) $setting;
			if ($setting_detail->name = 'Down Payment Percentage'){
				$discount_percent = $setting_detail->desc;
			}
		}

		return $discount_percent;
	}

	public function get_collection_info($id){
		$payment_obj = new paymentModel();
		return $payment_obj->get_collection_info($id);
	}

	public function get_collection_detail($id){
		$payment_obj = new paymentModel();
		return $payment_obj->get_collection_detail($id);
	}

	public function save_payment(){
		$transaction_id = $_POST['transaction_id'];
		$total_amount = $_POST['total_amount'];
		$balance_amount = $_POST['balance_amount'];
		$discounted_amount = $_POST['discounted_amount'];
		$cash_tendered = $_POST['cash_tendered'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$payment_obj = new paymentModel();
		$result = $payment_obj->save_payment($transaction_id, $total_amount, $balance_amount, $discounted_amount, $cash_tendered, $user, $datetime);
		echo $result;		
	}
}
?>