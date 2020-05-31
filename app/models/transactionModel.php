<?php

class transactionModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_latest_id(){
		$query = 'SELECT transaction_id FROM tbl_transaction_main WHERE transaction_id = (SELECT MAX(transaction_id) FROM tbl_transaction_main)';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		$id = '0';

		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare($query);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
		 	$id	= $data['transaction_id'];
		}
		
		$query = 'SELECT description FROM tbl_settings WHERE setting_name = "Branch Number"';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$branch = $data['description'];
		
		$patient_id = $this->id_format($id, 'TRANS', $branch);
		return $patient_id;
	}

	public function id_format($id, $prefix, $branch){
		$newID = "";
		$number;

		if ($id != '0'){
			$number = substr($id, 9);
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