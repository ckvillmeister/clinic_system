<?php

class reportController extends controller{

	public function index(){
		if (!($this->is_session_empty())){
			$service_obj = new serviceModel();
			$services = $service_obj->retrieve_services(1);
			$this->view()->render('main.php', array('content' => 'report/index.php', 'system_name' => $this->system_name(), 'services' => $services));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}
}
?>