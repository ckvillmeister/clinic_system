<?php

class serviceModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function retrieve_services($status){
		$query = 'SELECT record_id, name, description, rate, created_by
							FROM tbl_services
						WHERE status = ? ORDER BY record_id ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $name, $description, $rate, $created_by);
		$ctr=0;
		$services = array();

		while ($stmt->fetch()) {
			$userObj = new userModel();
			$user_info = $userObj->get_user_info($created_by);
			$creator = trim($user_info['firstname'].' '.$user_info['middlename'].' '.$user_info['lastname'].' '.$user_info['extension']);

			$services[$ctr++] = array('id' => $id, 
										'name' => $name,
										'description' => $description,
										'rate' => $rate,
										'createdby' => $creator);
		}

		$stmt->close();
		$this->con->close();
		return $services;
	}

	public function toggle_service_status($id, $status){
	
		$query = 'SELECT * FROM tbl_services WHERE record_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_services SET status = ? WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ss', $status, $id);
			$stmt->execute();
			return 1;
		}
	}

	public function get_service_info($id){
		$query = 'SELECT record_id, name, description, rate
							FROM tbl_services
							WHERE record_id = ?';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $name, $description, $rate);
		$service;

		while ($stmt->fetch()) {
			$service = array('id' => $id, 
								'name' => $name,
								'description' => $description,
								'rate' => $rate);
		}

		$stmt->close();
		$this->con->close();
		return $service;
	}

	public function insert_service($id, $name, $description, $rate, $user, $datetime){

		$status = 1;
		
		if (trim($id) != ''){
			$query = 'UPDATE tbl_services SET name = ?,
												description = ?,
												rate = ?,
												updated_by = ?,
												date_updated = ?,
												status = ?
												WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('sssssss', $name, $description, $rate, $user, $datetime, $status, $id);
			$stmt->execute();
			return 2;
		}
		else{
			$query = 'INSERT INTO tbl_services (name, description, rate, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssss', $name, $description, $rate, $user, $datetime, $status);
			$stmt->execute();
			return 1;
		}
	}
}