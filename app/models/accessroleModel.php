<?php

class accessroleModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function retrieve_roles($status){
		$query = 'SELECT record_id, role_name, description, created_by
							FROM tbl_access_roles
						WHERE status = ? ORDER BY record_id ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $name, $description, $created_by);
		$ctr=0;
		$roles = array();

		while ($stmt->fetch()) {
			$userObj = new userModel();
			$user_info = $userObj->get_user_info($created_by);
			$creator = trim($user_info['firstname'].' '.$user_info['middlename'].' '.$user_info['lastname'].' '.$user_info['extension']);

			$roles[$ctr++] = array('id' => $id, 
										'name' => $name,
										'description' => $description,
										'createdby' => $creator);
		}

		$stmt->close();
		$this->con->close();
		return $roles;
	}

	public function toggle_accessrole_status($id, $status){
	
		$query = 'SELECT * FROM tbl_access_roles WHERE record_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_access_roles SET status = ? WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ss', $status, $id);
			$stmt->execute();
			return 1;
		}
	}

	public function get_accessrole_info($id){
		$query = 'SELECT record_id, role_name, description
							FROM tbl_access_roles
							WHERE record_id = ?';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $name, $description);
		$accessrole;

		while ($stmt->fetch()) {
			$accessrole = array('id' => $id, 
								'name' => $name,
								'description' => $description);
		}

		$stmt->close();
		$this->con->close();
		return $accessrole;
	}

	public function insert_accessrole($id, $name, $description, $user, $datetime){

		$status = 1;
		
		if (trim($id) != ''){
			$query = 'UPDATE tbl_access_roles SET role_name = ?,
												description = ?,
												updated_by = ?,
												date_updated = ?,
												status = ?
												WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssss', $name, $description, $user, $datetime, $status, $id);
			$stmt->execute();
			return 2;
		}
		else{
			$query = 'INSERT INTO tbl_access_roles (role_name, description, created_by, date_created, status) VALUES (?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('sssss', $name, $description, $user, $datetime, $status);
			$stmt->execute();
			return 1;
		}
	}
}