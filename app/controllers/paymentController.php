<?php

class paymentController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'payment/index.php', 'system_name' => $this->system_name()));
	}
}
?>