<?php

class userModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
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
}