<?php

class transactionController extends controller{

	public function index(){
		$service_obj = new serviceModel();
		$services = $service_obj->retrieve_services(1);
		$this->view()->render('main.php', array('content' => 'transaction/index.php', 'services' => $services, 'system_name' => $this->system_name()));
	}

	public function get_transaction_id(){
		$transaction_obj = new transactionModel();
		$transaction_id = $transaction_obj->get_latest_id();
		echo $transaction_id;
	}

	public function retrieve_patients(){
		$status = $_POST['status'];

		$patient_obj = new patientModel();
		$patients = $patient_obj->retrieve_patients($status);
		$this->view()->render('transaction/patient_list.php', array('patients' => $patients, 'status' => $status));
	}

	public function get_patient_info(){
		$id = $_POST['id'];
		$patient_obj = new patientModel();
		$patient_info = $patient_obj->get_patient_info($id);
		echo json_encode($patient_info);
	}

	public function retrieve_products(){
		$status = $_POST['status'];

		$product_obj = new productModel();
		$products = $product_obj->retrieve_products($status);
		$this->view()->render('transaction/product_list.php', array('products' => $products, 'status' => $status));
	}

	public function get_product_info(){
		$id = $_POST['id'];
		$product_obj = new productModel();
		$product_info = $product_obj->get_product_info($id);
		echo json_encode($product_info);
	}

	public function get_service_info(){
		$id = $_POST['id'];
		$service_obj = new serviceModel();
		$service_info = $service_obj->get_service_info($id);
		echo json_encode($service_info);
	}

}

?>