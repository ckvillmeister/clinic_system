<?php

class reportController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'report/index.php', 'system_name' => $this->system_name()));
	}
}
?>