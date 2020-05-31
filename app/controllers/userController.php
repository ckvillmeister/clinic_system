<?php

class userController extends controller{

	public function index(){
		$accessrole_obj = new accessroleModel();
		$roles = $accessrole_obj->retrieve_roles(1);
		$this->view()->render('main.php', array('content' => 'maintenance/user/index.php', 'roles' => $roles, 'system_name' => $this->system_name()));
	}

	public function retrieve_users(){
		$status = $_POST['status'];

		$user_obj = new userModel();
		$users = $user_obj->retrieve_users($status);
		$this->view()->render('maintenance/user/user_list.php', array('users' => $users, 'status' => $status));
	}

	public function toggle_user_status(){
		$id = $_POST['id'];
		$status = $_POST['status'];

		$user_obj = new userModel();
		$result = $user_obj->toggle_user_status($id, $status);
		echo $result;
	}

	public function get_user_info(){
		$id = $_POST['id'];
		$user_obj = new userModel();
		$user_info = $user_obj->get_user_info($id);
		echo json_encode($user_info);
	}

	public function insert_user(){
		$id = $_POST['id'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$extension = $_POST['extension'];
		$role = $_POST['role'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$user_obj = new userModel();
		$result = $user_obj->insert_user($id, $username, $password, $firstname, $middlename, $lastname, $extension, $role, $user, $datetime);
		echo $result;
	}

	public function user_profile(){
		$id = $_GET['id'];
		$this->view()->render('main.php', array('content' => 'maintenance/user/user_profile.php', 'system_name' => $this->system_name()));
	}
}
?>