<?php

class transactionModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_latest_id(){
		$query = 'SELECT transaction_id FROM tbl_transaction_main WHERE transaction_id = (SELECT MAX(transaction_id) FROM tbl_transaction_main)';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$id = '0';

		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
		 	$id	= $data['transaction_id'];
		}
		
		$query = 'SELECT description FROM tbl_settings WHERE setting_name = "Branch Number"';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$branch = $data['description'];
		
		$patient_id = $this->id_format($id, 'TRANS', $branch);
		$stmt->close();
		$this->con->close();
		return $patient_id;
	}

	public function insert_transaction($transaction_id, $date, $patientid, $age, array $transaction_detail, $user, $datetime){
		$status = 1;
		
		$query = 'INSERT INTO tbl_transaction_main (transaction_id, transaction_date, patient_id, age_during_clinic_visit, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('sssssss', $transaction_id, $date, $patientid, $age, $user, $datetime, $status);
			$stmt->execute();

		$stmt = $this->con->prepare("SELECT record_id FROM tbl_transaction_main WHERE record_id = (SELECT MAX(record_id) FROM tbl_transaction_main)");
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
	 	$recordid	= $data['record_id'];

		foreach($transaction_detail as $row)
		{
			foreach($row as $data)
			{	
				$transact_date = $data[0];
				$service_product_id = $data[1];
    			$type = $data[2];
    			$remarks = $data[3];
    			$charge = $data[4];
    			$qty = $data[5];
    			$total = $data[6];

    			$query = 'INSERT INTO tbl_transaction_details (transaction_id, transaction_date, service_product_id, type, remarks, cost, quantity, total, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$stmt = $this->con->prepare($query);
				$stmt->bind_param('sssssssssss', $recordid, $transact_date, $service_product_id, $type, $remarks, $charge, $qty, $total, $user, $datetime, $status);
				$stmt->execute();
    			
				if ($type == 'Product'){
					$stmt = $this->con->prepare("SELECT quantity_on_hand FROM tbl_products WHERE record_id = ?");
					$stmt->bind_param('s', $service_product_id);
					$stmt->execute();
					$data = $stmt->get_result()->fetch_assoc();
				 	$qty_on_hand	= $data['quantity_on_hand'];

				 	$qty_on_hand -= $qty;
				 	$stmt = $this->con->prepare("UPDATE tbl_products SET quantity_on_hand = ? WHERE record_id = ?");
					$stmt->bind_param('ss', $qty_on_hand, $service_product_id);
					$stmt->execute();
				}

			}
		}

		$stmt->close();
		$this->con->close();
		return 1;

	}

	public function id_format($id, $prefix, $branch){
		$newID = "";
		$number;

		if ($id != '0'){
			$number = substr($id, 9);
		}
		else{
			$number = $id;
		}

		$number++;

		if ($number < 10){
			$newID = '0000000'.$number;
		}
		elseif ($number < 100){
			$newID = '000000'.$number;
		}
		elseif ($number < 1000){
			$newID = '00000'.$number;
		}
		elseif ($number < 10000){
			$newID = '0000'.$number;
		}
		elseif ($number < 100000){
			$newID = '000'.$number;
		}
		elseif ($number < 1000000){
			$newID = '00'.$number;
		}
		elseif ($number < 10000000){
			$newID = '0'.$number;
		}
		//echo $prefix.'<br>';
		//echo $branch.'<br>';
		//echo $newID.'<br>';
		$newID = $prefix.'-'.$branch.'-'.$newID;

		return $newID;
	}

}

?>