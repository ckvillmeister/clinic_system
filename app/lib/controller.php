<?php
require 'app/lib/view.php';

class controller{

	private $view;
	
	public function __construct(){
		session_start();
		$this->view = new view();
	}

	public function view(){
		return $this->view;
	}

	public function system_name(){
		$settings_obj = new settingsModel();
		$settings = $settings_obj->retrieve_settings();
		$system_name_detail = (object) $settings[0];
		return $system_name_detail->desc;
	}

	public function is_session_empty(){
		if (isset($_SESSION['user_id']) == ''){
			return true;
		}

		return false;
	}


}

?>