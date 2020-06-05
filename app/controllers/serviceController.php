<?php

class serviceController extends controller{

	public function index(){
		if (!($this->is_session_empty())){
			$this->view()->render('main.php', array('content' => 'services/index.php', 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}

	public function retrieve_services(){
		$status = $_POST['status'];

		$service_obj = new serviceModel();
		$services = $service_obj->retrieve_services($status);
		$this->view()->render('services/service_list.php', array('services' => $services, 'status' => $status));
	}

	public function toggle_service_status(){
		$id = $_POST['id'];
		$status = $_POST['status'];

		$service_obj = new serviceModel();
		$result = $service_obj->toggle_service_status($id, $status);
		echo $result;
	}

	public function get_service_info(){
		$id = $_POST['id'];
		$service_obj = new serviceModel();
		$service_info = $service_obj->get_service_info($id);
		echo json_encode($service_info);
	}

	public function insert_service(){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$rate = $_POST['rate'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$service_obj = new serviceModel();
		$result = $service_obj->insert_service($id, $name, $description, $rate, $user, $datetime);
		echo $result;
	}
}
?>