<?php

class userController extends controller{

	public function index(){
		if (!($this->is_session_empty())){
			$accessrole_obj = new accessroleModel();
			$roles = $accessrole_obj->retrieve_roles(1);
			$this->view()->render('main.php', array('content' => 'maintenance/user/index.php', 'roles' => $roles, 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
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
		if (!($this->is_session_empty())){

			$id = $_SESSION['user_id'];

			$user_obj = new userModel();
			$user_info = $user_obj->get_user_info($id);

			$this->view()->render('main.php', array('content' => 'maintenance/user/user_profile.php', 'user_info' => $user_info, 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}

	public function view_user_profile(){
		if (!($this->is_session_empty())){

			$id = $_GET['id'];

			$user_obj = new userModel();
			$user_info = $user_obj->get_user_info($id);

			$this->view()->render('main.php', array('content' => 'maintenance/user/user_profile.php', 'user_info' => $user_info, 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}

	public function change_password(){
		$old_password = $_POST['old_password'];
		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$user_obj = new userModel();
		$result = $user_obj->change_password($old_password, $new_password, $confirm_password, $user, $user, $datetime);
		echo $result;
	}

	public function reset_password(){
		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$user_obj = new userModel();
		$result = $user_obj->reset_password($new_password, $confirm_password, $user, $user, $datetime);
		echo $result;
	}
	
}
?>