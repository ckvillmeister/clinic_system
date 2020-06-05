<?php

class patientModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_city_mun(){
		$query = 'SELECT city_municipality_code, city_municipality_description FROM tbl_citymun WHERE province_code = 0712 ORDER BY city_municipality_description ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($code, $description);
		$ctr=0;
		while ($stmt->fetch()) {
			$mun_cities[$ctr++] = array('code' => $code, 
							'desc' => utf8_encode($description));
		}
		$stmt->close();
		$this->con->close();
		return $mun_cities;
	}

	public function get_barangays($code){
		$query = 'SELECT id, barangay_description FROM `tbl_barangay` WHERE `city_municipality_code` = ? ORDER BY barangay_description ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $code);
		$stmt->execute();
		$stmt->bind_result($id, $description);
		$ctr=0;

		while ($stmt->fetch()) {
			$barangays[$ctr++] = array('code' => $id, 
							'desc' => mb_strtoupper($description));
		}
		$stmt->close();
		$this->con->close();
		return $barangays;
	}

	public function get_latest_id(){
		$query = 'SELECT patient_id FROM tbl_patient_information WHERE patient_id = (SELECT MAX(patient_id) FROM tbl_patient_information)';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$id = '0';

		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
		 	$id	= $data['patient_id'];
		}
		
		$query = 'SELECT description FROM tbl_settings WHERE setting_name = "Branch Number"';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$branch = $data['description'];
		
		$patient_id = $this->id_format($id, 'PAT', $branch);
		return $patient_id;
	}

	public function retrieve_patients($status){
		$query = 'SELECT record_id, patient_id, firstname, middlename, lastname, 
							extension, sex, birthdate, address_purok, 
							address_brgy, address_citymun, contact_number, email, medical_history_remarks, created_by
							FROM tbl_patient_information AS tpi
						WHERE status = ? ORDER BY record_id ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $patientid, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $address_purok, $address_brgy, $address_citymun, $contact_number, $email, $remarks, $created_by);
		$ctr=0;
		$patients = array();

		while ($stmt->fetch()) {
			$userObj = new userModel();
			$user_info = $userObj->get_user_info($created_by);
			$creator = trim($user_info['firstname'].' '.$user_info['middlename'].' '.$user_info['lastname'].' '.$user_info['extension']);

			$patients[$ctr++] = array('id' => $id, 
										'patientid' => $patientid,
										'firstname' => $firstname,
										'middlename' => $middlename,
										'lastname' => $lastname,
										'extension' => $extension,
										'sex' => $sex,
										'birthdate' => $birthdate,
										'address_purok' => $address_purok,
										'address_brgy' => $address_brgy,
										'address_citymun' => $address_citymun,
										'contact_number' => $contact_number,
										'email' => $email,
										'remarks' => $remarks,
										'createdby' => $creator);
		}

		$stmt->close();
		$this->con->close();
		return $patients;
	}

	public function toggle_patient_status($id, $status){
	
		$query = 'SELECT * FROM tbl_patient_information WHERE record_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_patient_information SET status = ? WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ss', $status, $id);
			$stmt->execute();
			return 1;
		}
	}

	public function get_patient_info($id){
		$query = 'SELECT tpi.record_id, tpi.patient_id, tpi.firstname, tpi.middlename, tpi.lastname, 
							tpi.extension, tpi.sex, tpi.birthdate, tpi.address_purok, 
							tb.barangay_description, tc.city_municipality_description, tpi.contact_number, tpi.email, tpi.medical_history_remarks, tpi.created_by, tpi.address_brgy, tpi.address_citymun
							FROM tbl_patient_information AS tpi
							LEFT JOIN tbl_citymun AS tc ON tc.city_municipality_code = tpi.address_citymun
							LEFT JOIN tbl_barangay AS tb ON tb.id = tpi.address_brgy
						WHERE tpi.record_id = ?
						GROUP BY tpi.record_id';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $patientid, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $address_purok, $address_brgy, $address_citymun, $contact_number, $email, $remarks, $created_by, $address_brgy_id, $address_citymun_id);
		$patient;

		while ($stmt->fetch()) {
			$patient = array('id' => $id, 
										'patientid' => $patientid,
										'firstname' => $firstname,
										'middlename' => $middlename,
										'lastname' => $lastname,
										'extension' => $extension,
										'sex' => $sex,
										'birthdate' => $birthdate,
										'address_purok' => $address_purok,
										'address_brgy' => $address_brgy,
										'address_citymun' => $address_citymun,
										'contact_number' => $contact_number,
										'email' => $email,
										'remarks' => $remarks,
										'address_brgy_id' => $address_brgy_id,
										'address_citymun_id' => $address_citymun_id);
		}

		$stmt->close();
		$this->con->close();
		return $patient;
	}

	public function insert_patient($patient_id, $firstname, $middlename, $lastname, $extension, $addr_citymun, $addr_barangay, $addr_purok, $sex, $birthdate, $number, $email, $remarks, $user, $datetime, $proceed){

		
		$firstname = ucwords(strtolower($firstname)); 
		$middlename = ucwords(strtolower($middlename));
		$lastname = ucwords(strtolower($lastname));
		$extension = ($extension == 'II' | $extension == 'III' | $extension == 'IV') ? $extension : ucwords(strtolower($extension));
		$status = 1;

		$query = 'SELECT * FROM tbl_patient_information WHERE patient_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $patient_id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_patient_information SET patient_id = ?,
															firstname = ?,
															middlename = ?,
															lastname = ?,
															extension = ?,
															sex = ?,
															birthdate = ?,
															address_purok = ?,
															address_brgy = ?,
															address_citymun = ?,
															contact_number = ?,
															email = ?,
															medical_history_remarks = ?,
															updated_by = ?,
															date_updated = ?,
															status = ?
															WHERE patient_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('sssssssssssssssss', $patient_id, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $addr_purok, $addr_barangay, $addr_citymun, $number, $email, $remarks, $user, $datetime, $status, $patient_id);
			$stmt->execute();
			return 2;
		}
		else{
			$query = 'SELECT firstname, middlename, lastname, extension FROM tbl_patient_information WHERE firstname = ? AND middlename = ? AND lastname = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('sss', $firstname, $middlename, $lastname);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows >= 1){
				if ($proceed == 1){
					$query = 'INSERT INTO tbl_patient_information (patient_id, firstname, middlename, lastname, extension, sex, birthdate, address_purok, address_brgy, address_citymun, contact_number, email, medical_history_remarks, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
					$stmt = $this->con->prepare($query);
					$stmt->bind_param('ssssssssssssssss', $patient_id, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $addr_purok, $addr_barangay, $addr_citymun, $number, $email, $remarks, $user, $datetime, $status);
					$stmt->execute();
					return 1;
				}
				else{
					$stmt = $this->con->prepare($query);
					$stmt->bind_param('sss', $firstname, $middlename, $lastname);
					$stmt->execute();
					$stmt->bind_result($firstname, $middlename, $lastname, $extension);
					$ctr = 0;
					$matching_patient_name = array();

					while ($stmt->fetch()) {
						$matching_patient_name[$ctr++] = array('firstname' => $firstname,
																'middlename' => $middlename,
																'lastname' => $lastname,
																'extension' => $extension);
					}

					$stmt->close();
					$this->con->close();
					return $matching_patient_name;
				}
			}
			else{
				$query = 'INSERT INTO tbl_patient_information (patient_id, firstname, middlename, lastname, extension, sex, birthdate, address_purok, address_brgy, address_citymun, contact_number, email, medical_history_remarks, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$stmt = $this->con->prepare($query);
				$stmt->bind_param('ssssssssssssssss', $patient_id, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $addr_purok, $addr_barangay, $addr_citymun, $number, $email, $remarks, $user, $datetime, $status);
				$stmt->execute();
				return 1;
			}
		}
		
	}

	public function retrieve_payment_history($patient_id){
		$query = 'SELECT ttm.transaction_id, tcm.total_amount, tcm.discounted_amount, tcd.payment_amount, tcd.cash_tendered 
					FROM tbl_transaction_main AS ttm
					INNER JOIN tbl_collection_main AS tcm ON tcm.transaction_id = ttm.record_id
					INNER JOIN tbl_collection_details AS tcd ON tcd.collection_id = tcm.record_id 
						WHERE ttm.patient_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $patient_id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $patient_id);
			$stmt->execute();
			$stmt->bind_result($transaction_id, $total_amount, $discounted_amount, $payment_amount, $amount_tendered);
			$ctr = 0;
			$payments = array();

			while ($stmt->fetch()) {
				$payments[$ctr++] = array('transaction_id' => $transaction_id,
													'total_amount' => $total_amount,
													'discounted_amount' => $discounted_amount,
													'payment_amount' => $payment_amount,
													'amount_tendered' => $amount_tendered);
			}

			$stmt->close();
			$this->con->close();
			return $payments;

		}

		$stmt->close();
		$this->con->close();
		return 0;
	}

	public function retrieve_patient_services_availed($patient_id){
		$query = 'SELECT ttd.service_product_id, ttd.remarks
					FROM tbl_transaction_main AS ttm
					INNER JOIN tbl_transaction_details AS ttd ON ttd.transaction_id = ttm.record_id
						WHERE ttm.patient_id = ? AND ttd.status <> 0 AND ttd.type = "Service"';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $patient_id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $patient_id);
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

			$stmt->close();
			$this->con->close();
			return $services_availed;
		}

		$stmt->close();
		$this->con->close();
		return 0;
	}

	public function id_format($id, $prefix, $branch){
		$newID = "";
		$number;

		if ($id != '0'){
			$number = substr($id, 7);
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
		
		$newID = $prefix.'-'.$branch.'-'.$newID;

		return $newID;
	}

}

?>