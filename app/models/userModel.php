<?php

class userModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function retrieve_users($status){
		$query = 'SELECT record_id, username, firstname, middlename, lastname, extension, role_type, created_by
							FROM tbl_users
						WHERE status = ? ORDER BY record_id ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $username, $firstname, $middlename, $lastname, $extension, $role, $created_by);
		$ctr=0;
		$users = array();

		while ($stmt->fetch()) {
			$userObj = new userModel();
			$user_info = $userObj->get_user_info($created_by);
			$creator = trim($user_info['firstname'].' '.$user_info['middlename'].' '.$user_info['lastname'].' '.$user_info['extension']);

			$roleObj = new accessroleModel();
			$role_info = $roleObj->get_accessrole_info($role);
			$role = $role_info['name'];

			$users[$ctr++] = array('id' => $id, 
										'username' => $username,
										'firstname' => $firstname,
										'middlename' => $middlename,
										'lastname' => $lastname,
										'extension' => $extension,
										'role' => $role,
										'createdby' => $creator);
		}

		$stmt->close();
		$this->con->close();
		return $users;
	}

	public function toggle_user_status($id, $status){

		$user_info = $this->get_user_info($id);
		$role_id = $user_info['role_type'];

		if ($role_id == 1 & $status == 0){
			$query = 'SELECT * FROM tbl_users WHERE role_type = ? AND status = 1';
			$db = new database();
			$this->con = $db->connection();
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $role_id);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows == 1){
				return 2;
			}
		}

		$query = 'SELECT * FROM tbl_users WHERE record_id = ?';
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_users SET status = ? WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ss', $status, $id);
			$stmt->execute();
			return 1;
		}
		
	}


	public function get_user_info($userid){
		
		$stmt = $this->con->prepare("SELECT * FROM tbl_users WHERE record_id = ?");
		$stmt->bind_param("s", $userid);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare("SELECT username, firstname, middlename, lastname, extension, role_type FROM tbl_users WHERE record_id = ?");
			$stmt->bind_param("s", $userid);
			$stmt->execute();
			$stmt->bind_result($username, $firstname, $middlename, $lastname, $extension, $role_type);
			$user_info;

			while ($stmt->fetch()) {
				$user_info = array('username' => $username,
										'firstname' => $firstname,
										'middlename' => $middlename,
										'lastname' => $lastname,
										'extension' => $extension,
										'role_type' => $role_type);
			}

			$stmt->close();
			$this->con->close();
			return $user_info;
			
		}

	}

	public function insert_user($id, $username, $password, $firstname, $middlename, $lastname, $extension, $role, $user, $datetime){

		$status = 1;
		$password = md5($password);
		
		if (trim($id) != ''){
			$query = 'UPDATE tbl_users SET username = ?,
												firstname = ?,
												middlename = ?,
												lastname = ?,
												extension = ?,
												role_type = ?,
												updated_by = ?,
												date_updated = ?,
												status = ?
												WHERE record_id = ?';

			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssssssss', $username, $firstname, $middlename, $lastname, $extension, $role, $user, $datetime, $status, $id);
			$stmt->execute();
			return 2;
		}
		else{
			$query = 'INSERT INTO tbl_users (username, password, firstname, middlename, lastname, extension, role_type, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssssssss', $username, $password, $firstname, $middlename, $lastname, $extension, $role, $user, $datetime, $status);
			$stmt->execute();
			return 1;
		}
	}
}