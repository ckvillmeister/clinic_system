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
		$id = 0;

		if ($result->num_rows >= 1){
			$db = new database();
			$connection = $db->connection();

			$stmt = $connection->prepare($query);
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

	public function id_format($id, $prefix, $branch){
		$newID = "";
		$number;

		if ($id != 0){
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