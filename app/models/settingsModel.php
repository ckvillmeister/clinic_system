
<?php

class settingsModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function retrieve_settings(){
		$query = 'SELECT record_id, setting_name, description FROM tbl_settings WHERE status = 1';

		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $name, $desc);
		$ctr=0;
		while ($stmt->fetch()) {
			$setting[$ctr++] = array('id' => $id, 
							'name' => $name, 
							'desc' => $desc);
		}
		$stmt->close();
		$this->con->close();
		return $setting;
	}

	public function save_settings($system_name, $address, $branch_no, $down_payment){
		if ($branch_no < 10){
			$branch_no = '0'.ltrim($branch_no, '0');
		}

		$query = 'SELECT * FROM tbl_settings WHERE setting_name = "System Name"';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_settings SET description = ? WHERE setting_name = "System Name"';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $system_name);
			$stmt->execute();
		}
		else{
			$query = 'INSERT INTO tbl_settings (setting_name, description, status) VALUES ("System Name", ?, 1)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $system_name);
			$stmt->execute();
		}

		$query = 'SELECT * FROM tbl_settings WHERE setting_name = "Address"';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_settings SET description = ? WHERE setting_name = "Address"';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $address);
			$stmt->execute();
		}
		else{
			$query = 'INSERT INTO tbl_settings (setting_name, description, status) VALUES ("Address", ?, 1)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $address);
			$stmt->execute();
		}

		$query = 'SELECT * FROM tbl_settings WHERE setting_name = "Branch Number"';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_settings SET description = ? WHERE setting_name = "Branch Number"';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $branch_no);
			$stmt->execute();
		}
		else{
			$query = 'INSERT INTO tbl_settings (setting_name, description, status) VALUES ("Branch Number", ?, 1)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $branch_no);
			$stmt->execute();
		}

		$down_payment = $down_payment / 100;
		$query = 'SELECT * FROM tbl_settings WHERE setting_name = "Down Payment Percentage"';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_settings SET description = ? WHERE setting_name = "Down Payment Percentage"';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $down_payment);
			$stmt->execute();
		}
		else{
			$query = 'INSERT INTO tbl_settings (setting_name, description, status) VALUES ("Down Payment Percentage", ?, 1)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('s', $down_payment);
			$stmt->execute();
		}

		$stmt->close();
		$this->con->close();
		return 1;
	}

}