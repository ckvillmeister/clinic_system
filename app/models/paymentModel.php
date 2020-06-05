<?php

class paymentModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_transaction_info($transaction_id){
		$query = 'SELECT record_id, patient_id FROM tbl_transaction_main WHERE transaction_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $transaction_id);
		$stmt->execute();

		if ($stmt->get_result()->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->bind_param("s", $transaction_id);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$patient_obj = new patientModel();
			$patient_info = $patient_obj->get_patient_info($data['patient_id']);
				
			$info = array('id' => $data['record_id'],
							'patient_info' => $patient_info);
			

			$stmt->close();
			$this->con->close();
			return $info;
		}
		else{
			$stmt->close();
			$this->con->close();
			return 0;
		}
		
	}

	public function get_transaction_detail($transaction_id){
		$query = 'SELECT service_product_id, type, cost, quantity, total FROM tbl_transaction_details WHERE transaction_id = ?';
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $transaction_id);
		$stmt->execute();
		$stmt->bind_result($id, $type, $cost, $quantity, $total);
		$ctr=0;
		$transaction_details = array();

		while ($stmt->fetch()) {
			$name;
			if ($type=='Service'){
				$obj_service = new serviceModel();
				$service_info = $obj_service->get_service_info($id);
				$name = $service_info['name'];
			}
			elseif ($type=='Product'){
				$obj_product = new productModel();
				$product_info = $obj_product->get_product_info($id);
				$name = $product_info['name'];
			}

			$transaction_details[$ctr++] = array('service_product_info' => $name,
													'type' => $type,
													'cost' => $cost,
													'quantity' => $quantity,
													'total' => $total);
		}

		$stmt->close();
		$this->con->close();
		return $transaction_details;
	}

	public function get_transaction_list($status){
		$query = 'SELECT record_id, transaction_id, patient_id FROM tbl_transaction_main WHERE status = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $transaction_id, $patient_id);
		$ctr=0;
		$transactions = array();

		while ($stmt->fetch()) {
			$patient_obj = new patientModel();
			$patient_info = $patient_obj->get_patient_info($patient_id);
			$transactions[$ctr++] = array('id' => $id,
											'transaction_id' => $transaction_id,
											'patient_info' => $patient_info);
		}

		$stmt->close();
		$this->con->close();
		return $transactions;
	}

	public function get_collection_info($id){
		$query = 'SELECT record_id, transaction_id, total_amount, discounted_amount FROM tbl_collection_main WHERE transaction_id = ? AND status = 1';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();

		if ($stmt->get_result()->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->bind_param("s", $id);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
				
			$collection_info = array('id' => $data['record_id'],
							'transaction_id' => $data['transaction_id'],
							'total_amount' => $data['total_amount'],
							'discounted_amount' => $data['discounted_amount']);
				

			$stmt->close();
			$this->con->close();
			return $collection_info;
		}
		else{
			$stmt->close();
			$this->con->close();
			return 0;
		}
		
	}

	public function get_collection_detail($id){
		$query = 'SELECT record_id, collection_id, payment_amount FROM tbl_collection_details WHERE collection_id = ?';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $collection_id, $payment);
		$ctr=0;
		$payment_details = array();

		while ($stmt->fetch()) {
			$payment_details[$ctr++] = array('id' => $id,
												'collection_id' => $collection_id,
												'amount_paid' => $payment);
		}

		$stmt->close();
		$this->con->close();
		return $payment_details;
	}

	public function save_payment($transaction_id, $total_amount, $balance_amount, $discounted_amount, $cash_tendered, $user, $datetime){
		$status = 1;
		$query = 'SELECT * FROM tbl_collection_main WHERE transaction_id = ? AND status = 1';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $transaction_id);
		$stmt->execute();

		$difference = 0;
		$payment = 0;

		if ($cash_tendered > $balance_amount){
			$payment = $balance_amount;
		}
		else{
			$payment = $cash_tendered;
		}

		$difference = $balance_amount - $payment;

		if ($stmt->get_result()->num_rows >= 1){

			if ($difference <= 0){
				$query = 'UPDATE tbl_transaction_main SET status = 2 WHERE record_id = ?';
				$stmt = $this->con->prepare($query);
				$stmt->bind_param('s', $transaction_id);
				$stmt->execute();

				$query = 'UPDATE tbl_transaction_details SET status = 2 WHERE transaction_id = ?';
				$stmt = $this->con->prepare($query);
				$stmt->bind_param('s', $transaction_id);
				$stmt->execute();
			}
	
			$stmt = $this->con->prepare("SELECT record_id FROM tbl_collection_main WHERE transaction_id = ?");
			$stmt->bind_param('s', $transaction_id);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
		 	$collection_id	= $data['record_id'];

		 	$query = 'INSERT INTO tbl_collection_details (collection_id, payment_amount, cash_tendered, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssss', $collection_id, $payment, $cash_tendered, $user, $datetime, $status);
			$stmt->execute();

			$stmt->close();
			$this->con->close();
			return 1;
			
		}
		else{
			if ($difference <= 0){
				$query = 'UPDATE tbl_transaction_main SET status = 2 WHERE record_id = ?';
				$stmt = $this->con->prepare($query);
				$stmt->bind_param('s', $transaction_id);
				$stmt->execute();

				$query = 'UPDATE tbl_transaction_details SET status = 2 WHERE transaction_id = ?';
				$stmt = $this->con->prepare($query);
				$stmt->bind_param('s', $transaction_id);
				$stmt->execute();
			}

			$query = 'INSERT INTO tbl_collection_main (date_of_payment, transaction_id, total_amount, discounted_amount, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('sssssss', $datetime, $transaction_id, $total_amount, $discounted_amount, $user, $datetime, $status);
			$stmt->execute();

			$stmt = $this->con->prepare("SELECT record_id FROM tbl_collection_main WHERE transaction_id = ?");
			$stmt->bind_param('s', $transaction_id);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
		 	$collection_id	= $data['record_id'];

		 	$query = 'INSERT INTO tbl_collection_details (collection_id, payment_amount, cash_tendered, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssss', $collection_id, $payment, $cash_tendered, $user, $datetime, $status);
			$stmt->execute();

			$stmt->close();
			$this->con->close();
			return 1;
		}

	}
	
}