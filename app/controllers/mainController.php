<?php

class mainController extends controller{

	public function index(){
		if (!($this->is_session_empty())){
			$this->view()->render('main.php', array('content' => 'main/index.php', 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}
}
?>