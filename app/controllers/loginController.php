<?php 

class loginController extends controller{

	private $model;
	
	public function index(){
		$this->view()->render('login\login.php');
	}

	public function validate_login(){
		$this->model = new loginModel();
		$username = $_POST['username'];
		$password = $_POST['password'];
		$datetime = date('Y-m-d H:i:s');
		$result = $this->model->validate_login(array('username' => $username, 'password' => $password, 'datetime' => $datetime));
		
		echo json_encode($result);
	}

}

?>