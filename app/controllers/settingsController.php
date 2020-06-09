<?php

class settingsController extends controller{
	
	public function index(){
		if (!($this->is_session_empty())){
			$setting_obj = new settingsModel();
			$settings = $setting_obj->retrieve_settings();
			$this->view()->render('main.php', array('content' => 'maintenance/system_settings/index.php', 'settings' => $settings, 'system_name' => $this->system_name()));
		}
		else{
			header("Location: ".ROOT);
		}
	}

	public function save_settings(){
		$system_name = $_POST['system_name'];
		$address = $_POST['address'];
		$branch_no = $_POST['branch_no'];
		$down_payment = $_POST['down_payment'];

		$setting_obj = new settingsModel();
		$result = $setting_obj->save_settings($system_name, $address, $branch_no, $down_payment);
		echo $result;
	}

	public function back_up_database(){
		$str = exec('start /B C:\xampp\htdocs\clinic_system\app\lib\database-backup.bat'); 
		//exec('c:\WINDOWS\system32\cmd.exe /c START C:\xampp\htdocs\clinic_system\app\lib\database-backup.bat');
		//return 1;
	}

}

?>