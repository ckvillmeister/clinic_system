<?php

class dashboardModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function count_records($table){
		$query = 'SELECT COUNT(*) AS record_count FROM '.$table.' WHERE status = 1';

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
		 	$count	= $data['record_count'];
			return $count;
		}

		$stmt->close();
		$this->con->close();
		return 0;
	}

	public function count_patients_with_balance(){
		$query = 'SELECT record_id, transaction_id, patient_id FROM tbl_transaction_main';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $transaction_id, $patient_id);
		$ctr=0;
		$report = array();

		while ($stmt->fetch()) {
			$total_charge = 0;
			$discount = 0;
			$balance = 0;
			$paid = 0;
			$new_query = 'SELECT * FROM tbl_collection_main WHERE transaction_id = ?';
			
			$db = new database();
			$connection = $db->connection();
			$stmt_2 = $connection->prepare($new_query);
			$stmt_2->bind_param('s', $id);
			$stmt_2->execute();
			$result = $stmt_2->get_result();

			if ($result->num_rows >= 1){
				$report_obj = new reportModel();

				$collection_details = (object) $report_obj->get_collection_info($id);
				$collection_id = $collection_details->collection_id;
				$total_amount = $collection_details->total_amount;
				$discounted_amount = $collection_details->discounted_amount;
				$total_paid = $report_obj->get_total_paid_amount($collection_id);
				$paid = $total_paid;

				if ($discounted_amount == 0 | $discounted_amount == ''){
					$total_charge = $total_amount;
					$balance = $total_amount - $total_paid;
				}
				else{
					$total_charge = $total_amount;
					$discount = $discounted_amount;
					$balance = $discounted_amount - $total_paid;
				}

			}
			else{
				$total_charge = $report_obj->get_total_charge_amount($id);
				$balance = $total_charge;
			}

			if (!($balance <= 0)){
				$ctr++;
			}
		
		}

		$stmt->close();
		$this->con->close();
		return $ctr;
	}

	public function retrieve_patients_stats(){
		$ctr = 1;
		$current_year = date('Y');
		$records = array();

		while ($ctr <= 12){
			$stmt = $this->con->prepare("SELECT record_id as record_count FROM tbl_transaction_main WHERE MONTH(transaction_date) = ".$ctr." AND YEAR(transaction_date) = ".$current_year." AND status <> 0 GROUP BY patient_id");
			$stmt->execute();
			$result = $stmt->get_result();
		 	$count	= $result->num_rows;
			
			$records[] = $count;
			$ctr++;
		}

		return $records;
	}

	public function retrieve_collection_stats(){
		$ctr = 1;
		$current_year = date('Y');
		$records = array();

		while ($ctr <= 12){
			$total = 0;
			$stmt = $this->con->prepare("SELECT payment_amount FROM tbl_collection_details WHERE MONTH(date_created) = ".$ctr." AND YEAR(date_created) = ".$current_year." AND status <> 0");
			$stmt->execute();
			$stmt->bind_result($amount);
			
			while ($stmt->fetch()) {
				$total += $amount;
			}
			
			$records[] = $total;
			$ctr++;
		}

		return $records;
	}
}