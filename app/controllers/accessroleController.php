<?php

class accessroleController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'maintenance/access_role/index.php', 'system_name' => $this->system_name()));
	}

	public function retrieve_accessroles(){
		$status = $_POST['status'];

		$accessrole_obj = new accessroleModel();
		$roles = $accessrole_obj->retrieve_roles($status);
		$this->view()->render('maintenance/access_role/accessrole_list.php', array('roles' => $roles, 'status' => $status));
	}

	public function toggle_accessrole_status(){
		$id = $_POST['id'];
		$status = $_POST['status'];

		$accessrole_obj = new accessroleModel();
		$result = $accessrole_obj->toggle_accessrole_status($id, $status);
		echo $result;
	}

	public function get_accessrole_info(){
		$id = $_POST['id'];
		$accessrole_obj = new accessroleModel();
		$accessrole_info = $accessrole_obj->get_accessrole_info($id);
		echo json_encode($accessrole_info);
	}

	public function insert_accessrole(){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$accessrole_obj = new accessroleModel();
		$result = $accessrole_obj->insert_accessrole($id, $name, $description, $user, $datetime);
		echo $result;
	}
}

?>