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
							address_brgy, address_citymun, contact_number, email, created_by
							FROM tbl_patient_information AS tpi
						WHERE status = ? ORDER BY record_id ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $patientid, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $address_purok, $address_brgy, $address_citymun, $contact_number, $email, $created_by);
		$ctr=0;

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
										'createdby' => $creator);
		}

		$stmt->close();
		$this->con->close();
		return $patients;
	}

	public function get_patient_info($id){
		$query = 'SELECT record_id, patient_id, firstname, middlename, lastname, 
							extension, sex, birthdate, address_purok, 
							address_brgy, address_citymun, contact_number, email, created_by
							FROM tbl_patient_information AS tpi
						WHERE record_id = ?';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $patientid, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $address_purok, $address_brgy, $address_citymun, $contact_number, $email, $created_by);
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
										'email' => $email);
		}

		$stmt->close();
		$this->con->close();
		return $patient;
	}

	public function insert_patient($patient_id, $firstname, $middlename, $lastname, $extension, $addr_citymun, $addr_barangay, $addr_purok, $sex, $birthdate, $number, $email, $user, $datetime){

		$firstname = ucwords($firstname); 
		$middlename = ucwords($middlename);
		$lastname = ucwords($lastname);
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
															updated_by = ?,
															date_updated = ?,
															status = ?
															WHERE patient_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssssssssssssss', $patient_id, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $addr_purok, $addr_barangay, $addr_citymun, $number, $email, $user, $datetime, $status, $patient_id);
			$stmt->execute();
			return 2;
		}
		else{
			$query = 'INSERT INTO tbl_patient_information (patient_id, firstname, middlename, lastname, extension, sex, birthdate, address_purok, address_brgy, address_citymun, contact_number, email, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('sssssssssssssss', $patient_id, $firstname, $middlename, $lastname, $extension, $sex, $birthdate, $addr_purok, $addr_barangay, $addr_citymun, $number, $email, $user, $datetime, $status);
			$stmt->execute();
			return 1;
		}
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
		//echo $prefix.'<br>';
		//echo $branch.'<br>';
		//echo $newID.'<br>';
		$newID = $prefix.'-'.$branch.'-'.$newID;

		return $newID;
	}

}

?>