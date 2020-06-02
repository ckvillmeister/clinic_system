<?php

class paymentModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_transaction_info($transaction_id){
		$query = 'SELECT record_id, patient_id FROM tbl_transaction_main WHERE transaction_id = ? AND status = 1';
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
	
}