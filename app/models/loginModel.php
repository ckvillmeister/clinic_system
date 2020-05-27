<?php

class loginModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}
	
	public function validate_login($param = array()){
		$username = $param['username'];
		$password = $param['password'];

		$stmt = $this->con->prepare("SELECT * FROM tbl_users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows <= 0){
			$stmt->close();
			$this->con->close();
			return 2;
		}

		$stmt = $this->con->prepare("SELECT * FROM tbl_users WHERE username = ? AND password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows <= 0){
			$stmt->close();
			$this->con->close();
			return 3;
		}

		$stmt = $this->con->prepare("SELECT record_id, username, firstname, middlename, lastname FROM tbl_users WHERE username = ? AND password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$stmt->bind_result($id, $username, $firstname, $middlename, $lastname);
	
		while ($stmt->fetch()) {
			$_SESSION['user_id'] = $id;
			$_SESSION['username'] = $username;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['middlename'] = $middlename;
			$_SESSION['lastname'] = $lastname;
		}

		$stmt->close();
		$this->con->close();
		return 1;

		
	}
}

?>