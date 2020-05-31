<?php

class productController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'product/index.php', 'system_name' => $this->system_name()));
	}

	public function retrieve_products(){
		$status = $_POST['status'];

		$product_obj = new productModel();
		$products = $product_obj->retrieve_products($status);
		$this->view()->render('product/product_list.php', array('products' => $products, 'status' => $status));
	}

	public function toggle_product_status(){
		$id = $_POST['id'];
		$status = $_POST['status'];

		$product_obj = new productModel();
		$result = $product_obj->toggle_product_status($id, $status);
		echo $result;
	}

	public function get_product_info(){
		$id = $_POST['id'];
		$product_obj = new productModel();
		$product_info = $product_obj->get_product_info($id);
		echo json_encode($product_info);
	}

	public function insert_product(){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$reorder = $_POST['reorder'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$product_obj = new productModel();
		$result = $product_obj->insert_product($id, $name, $description, $price, $quantity, $reorder, $user, $datetime);
		echo $result;
	}

}
?>