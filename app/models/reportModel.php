<?php

class reportModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function transaction_report($status, $services, $months, $from, $to){
		$filter = 0;
		$query = 'SELECT ttm.record_id, ttm.transaction_id, ttm.transaction_date, ttm.patient_id, ttm.status
					FROM tbl_transaction_main AS ttm';

		if ($services != ''){
			$query .= ' INNER JOIN tbl_transaction_details AS ttd ON ttd.transaction_id = ttm.record_id';
		}

		if ($status != '' | $services != '' | $months != '' | $from != '' | $to != ''){
			$query .= ' WHERE';
			$filter = 1;
		}

		if ($status != ''){
			$query .= ' ttm.status = '.$status.' AND';
		}

		if ($services != ''){
			$query .= ' ttd.service_product_id = '.$services.' AND ttd.type = "Service" AND';
		}

		if ($months != ''){
			$query .= ' MONTH(ttm.transaction_date) = '.$months.' AND';
		}

		if ($from != ''){
			$query .= ' (';
			for ($from; $from <= $to; $from++) { 
				$query .= ' YEAR(ttm.transaction_date) = '.$from.' OR';
			}
			$query = substr($query, 0, -3);
			$query .= ') AND';
		}

		if ($filter == 1){
			$query = substr($query, 0, -4);
		}
		
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $transaction_id, $date, $patient_id, $status);
		$ctr=0;
		$report = array();

		while ($stmt->fetch()) {
			$patient_obj = new patientModel();
			$patient_info = $patient_obj->get_patient_info($patient_id);
			$services_availed = $this->retrieve_services_availed($id);

			$report[$ctr++] = array('id' => $id,
									'transaction_id' => $transaction_id,
									'date' => $date,
									'patient_name' => $patient_info,
									'services_availed' => $services_availed,
									'status' => $status);
		}

		$stmt->close();
		$this->con->close();
		return $report;
	}

	public function patient_report($filter){
		if ($filter != ''){
			if ($filter == 1){
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
						$collection_details = (object) $this->get_collection_info($id);
						$collection_id = $collection_details->collection_id;
						$total_amount = $collection_details->total_amount;
						$discounted_amount = $collection_details->discounted_amount;
						$total_paid = $this->get_total_paid_amount($collection_id);
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
						$total_charge = $this->get_total_charge_amount($id);
						$balance = $total_charge;
					}

					if (!($balance <= 0)){
						$patient_obj = new patientModel();
						$patient_info = $patient_obj->get_patient_info($patient_id);

						$report[$ctr++] = array('patient_info' => $patient_info,
											'transaction_id' => $transaction_id,
											'total_amount' => $total_charge,
											'discounted_amount' => $discount,
											'total_paid' => $paid,
											'balance' => $balance);
					}
				
				}

				$stmt->close();
				$this->con->close();
				return $report;
			}
			elseif ($filter == 2){
				$query = 'SELECT patient_id, COUNT(transaction_id) AS no_of_visits 
							FROM tbl_transaction_main 
							WHERE status <> 0 
							GROUP BY patient_id 
							ORDER BY no_of_visits DESC';

				$stmt = $this->con->prepare($query);
				$stmt->execute();
				$stmt->bind_result($patient_id, $no_of_visits);
				$ctr=0;
				$report = array();

				while ($stmt->fetch()) {
					$patient_obj = new patientModel();
					$patient_info = $patient_obj->get_patient_info($patient_id);

					$report[$ctr++] = array('patient_info' => $patient_info,
										'no_of_visits' => $no_of_visits);
				}

				$stmt->close();
				$this->con->close();
				return $report;
			}
		}
		else{
			$patient_obj = new patientModel();
			$report = $patient_obj->retrieve_patients(1);

			return $report;
		}
	}

	public function product_report($filter){
		if ($filter != ''){
			if ($filter == 1){
				$query = 'SELECT service_product_id, COUNT(service_product_id) AS times_sold 
							FROM tbl_transaction_details 
							WHERE status <> 0 AND type = "Product"
							GROUP BY service_product_id 
							ORDER BY times_sold DESC';

				$stmt = $this->con->prepare($query);
				$stmt->execute();
				$stmt->bind_result($product_id, $count);
				$ctr=0;
				$report = array();

				while ($stmt->fetch()) {
					$product_obj = new productModel();
					$product_info = $product_obj->get_product_info($product_id);

					$report[$ctr++] = array('product_info' => $product_info,
											'times_sold' => $count);
				}

				$stmt->close();
				$this->con->close();
				return $report;
			}
			elseif($filter == 2){
				$query = 'SELECT tp.record_id, tp.name, tp.description, tp.unit_of_measurement, tp.price, tp.quantity_on_hand, tp.reorder_level
							FROM `tbl_products` AS tp 
							WHERE tp.quantity_on_hand < (SELECT tp2.reorder_level FROM tbl_products AS tp2 WHERE tp2.record_id = tp.record_id)';

				$stmt = $this->con->prepare($query);
				$stmt->execute();
				$stmt->bind_result($product_id, $name, $desc, $uom, $price, $qty, $reorder);
				$ctr=0;
				$report = array();

				while ($stmt->fetch()) {
					$product_obj = new productModel();
					$product_info = $product_obj->get_product_info($product_id);

					$report[$ctr++] = array('id' => $product_id,
											'name' => $name,
											'description' => $desc,
											'uom' => $uom,
											'price' => $price,
											'quantity' => $qty,
											'reorder' => $reorder);
				}

				$stmt->close();
				$this->con->close();
				return $report;
			}
		}
		else{
			$product_obj = new productModel();
			$report = $product_obj->retrieve_products(1);	
			return $report;
		}
	}

	public function collection_report($month, $year){
		$filter = 0;
		$query = 'SELECT tcm.record_id, ttm.transaction_id, ttm.patient_id, tcm.total_amount, tcm.discounted_amount 
					FROM tbl_collection_main AS tcm
					INNER JOIN tbl_transaction_main AS ttm ON ttm.record_id = tcm.transaction_id';

		if ($month != '' | $year != ''){
			$query .= ' WHERE';
			$filter = 1;
		}

		if ($month != ''){
			$query .= ' MONTH(tcm.date_of_payment) = '.$month.' AND';
		}

		if ($year != ''){
			$query .= ' YEAR(tcm.date_of_payment) = '.$year.' AND';
		}

		if ($filter == 1){
			$query = substr($query, 0, -4);
		}		

		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($collection_id, $transaction_id, $patient_id, $total_amount, $discounted_amount);
		$ctr=0;
		$report = array();

		while ($stmt->fetch()) {
			$patient_obj = new patientModel();
			$patient_info = $patient_obj->get_patient_info($patient_id);

			$total_charge = 0;
			if ($discounted_amount == '' | $discounted_amount == 0){
				$total_charge = $total_amount;
			}
			else{
				$total_charge = $discounted_amount;
			}

			$report[$ctr++] = array('transaction_id' => $transaction_id,
									'total_charge' => $total_charge,
									'total_paid' => $this->get_total_paid_amount($collection_id),
									'patient_info' => $patient_info);
		}

		$stmt->close();
		$this->con->close();
		return $report;
	}
	
	public function retrieve_services_availed($id){
		$query = 'SELECT ttd.service_product_id, ttd.remarks
					FROM tbl_transaction_main AS ttm
					INNER JOIN tbl_transaction_details AS ttd ON ttd.transaction_id = ttm.record_id
						WHERE ttm.record_id = ? AND ttd.status <> 0 AND ttd.type = "Service"';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$stmt = $connection->prepare($query);
			$stmt->bind_param('s', $id);
			$stmt->execute();
			$stmt->bind_result($service_id, $remarks);
			$ctr = 0;
			$services_availed = array();

			while ($stmt->fetch()) {
				$service_obj = new serviceModel();
				$service = $service_obj->get_service_info($service_id);

				$services_availed[$ctr++] = array('id' => $service_id,
													'name' => $service['name'],
													'description' => $service['description'],
													'remarks' => $remarks);
			}

			return $services_availed;
		}

		return 0;
	}

	public function get_collection_info($transaction_id){
		$query = 'SELECT record_id, total_amount, discounted_amount FROM tbl_collection_main WHERE transaction_id = ? AND status = 1';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $transaction_id);
		$stmt->execute();
		$stmt->bind_result($id, $total_amount, $discounted_amount);
		$collection_info;

		while ($stmt->fetch()) {
			$collection_info = array('collection_id' => $id,
										'total_amount' => $total_amount,
										'discounted_amount' => $discounted_amount);
		}

		return $collection_info;
	}

	public function get_total_paid_amount($collection_id){
		$query = 'SELECT payment_amount FROM tbl_collection_details WHERE collection_id = ? AND status = 1';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $collection_id);
		$stmt->execute();
		$stmt->bind_result($total);
		$total_paid = 0;

		while ($stmt->fetch()) {
			$total_paid += $total;
		}

		return $total_paid;
	}

	public function get_total_charge_amount($transaction_id){
		$query = 'SELECT total FROM tbl_transaction_details WHERE transaction_id = ? AND status <> 0';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $transaction_id);
		$stmt->execute();
		$stmt->bind_result($total);
		$total_charge = 0;

		while ($stmt->fetch()) {
			$total_charge += $total;
		}

		return $total_charge;
	}
}

?>