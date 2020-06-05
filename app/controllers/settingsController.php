<?php

class settingsController extends controller{
	
	public function index(){
		if (!($this->is_session_empty())){
			$setting_obj = new settingsModel();
			$settings = $setting_obj->retrieve_settings();
			$this->view()->render('main.php', array('content' => 'maintenance/system_settings/index.php', 'settings' => $settings, 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}

	public function save_settings(){
		$system_name = $_POST['system_name'];
		$branch_no = $_POST['branch_no'];
		$down_payment = $_POST['down_payment'];

		$setting_obj = new settingsModel();
		$result = $setting_obj->save_settings($system_name, $branch_no, $down_payment);
		echo $result;
	}

}

?>