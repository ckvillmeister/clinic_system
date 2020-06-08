<?php 

class authenticationController extends controller{

	public function index(){
		if (!($this->is_session_empty())){
			header("Location: ".ROOT.'dashboard');
		}
		else{
			$this->view()->render('login\login.php');
		}
	}

	public function validate_login(){
		$auth_obj = new authenticationModel();
		$username = $_POST['username'];
		$password = $_POST['password'];
		$datetime = date('Y-m-d H:i:s');
		$result = $auth_obj->validate_login(array('username' => $username, 'password' => $password, 'datetime' => $datetime));
		
		echo json_encode($result);
	}

	public function logout(){
		session_destroy();
		header("Location: ".ROOT);
	}

}

?>