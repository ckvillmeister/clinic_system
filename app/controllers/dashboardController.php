<?php

class dashboardController extends controller{

	public function index(){	
		if (!($this->is_session_empty())){
			$this->view()->render('main.php', array('content' => 'dashboard/index.php', 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}
}
?>