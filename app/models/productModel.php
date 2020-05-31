<?php

class productModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function retrieve_products($status){
		$query = 'SELECT record_id, name, description, price, quantity_on_hand, reorder_level, created_by
							FROM tbl_products
						WHERE status = ? ORDER BY record_id ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $name, $description, $price, $quantity, $reorder, $created_by);
		$ctr=0;
		$products = array();

		while ($stmt->fetch()) {
			$userObj = new userModel();
			$user_info = $userObj->get_user_info($created_by);
			$creator = trim($user_info['firstname'].' '.$user_info['middlename'].' '.$user_info['lastname'].' '.$user_info['extension']);

			$products[$ctr++] = array('id' => $id, 
										'name' => $name,
										'description' => $description,
										'price' => $price,
										'quantity' => $quantity,
										'reorder' => $reorder,
										'createdby' => $creator);
		}

		$stmt->close();
		$this->con->close();
		return $products;
	}

	public function toggle_product_status($id, $status){
	
		$query = 'SELECT * FROM tbl_products WHERE record_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows >= 1){
			$query = 'UPDATE tbl_products SET status = ? WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ss', $status, $id);
			$stmt->execute();
			return 1;
		}
	}

	public function get_product_info($id){
		$query = 'SELECT record_id, name, description, price, quantity_on_hand, reorder_level
							FROM tbl_products
							WHERE record_id = ?';
		
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $name, $description, $price, $quantity, $reorder);
		$product;

		while ($stmt->fetch()) {
			$product = array('id' => $id, 
								'name' => $name,
								'description' => $description,
								'price' => $price,
								'quantity' => $quantity,
								'reorder' => $reorder);
		}

		$stmt->close();
		$this->con->close();
		return $product;
	}

	public function insert_product($id, $name, $description, $price, $quantity, $reorder, $user, $datetime){

		$status = 1;
		
		if (trim($id) != ''){
			$query = 'UPDATE tbl_products SET name = ?,
												description = ?,
												price = ?,
												quantity_on_hand = ?,
												reorder_level = ?,
												updated_by = ?,
												date_updated = ?,
												status = ?
												WHERE record_id = ?';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('sssssssss', $name, $description, $price, $quantity, $reorder, $user, $datetime, $status, $id);
			$stmt->execute();
			return 2;
		}
		else{
			$query = 'INSERT INTO tbl_products (name, description, price, quantity_on_hand, reorder_level, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
			$stmt = $this->con->prepare($query);
			$stmt->bind_param('ssssssss', $name, $description, $price, $quantity, $reorder, $user, $datetime, $status);
			$stmt->execute();
			return 1;
		}
	}
}