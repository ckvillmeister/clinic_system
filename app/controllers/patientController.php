<?php

class patientController extends controller{

	public function index(){
		$patient_obj = new patientModel();
		$muncities = $patient_obj->get_city_mun();
		$this->view()->render('main.php', array('content' => 'patient/index.php', 'muncities' => $muncities));
	}

	public function retrieve_barangays(){
		$mun_city_code = $_POST['code'];

		$patient_obj = new patientModel();
		$barangays = $patient_obj->get_barangays($mun_city_code);
		$this->view()->render('patient/barangay_list.php', array('barangays' => $barangays));
	}

	public function get_patient_id(){
		$patient_obj = new patientModel();
		$patient_id = $patient_obj->get_latest_id();
		echo $patient_id;
	}

	public function insert_patient(){
		$patient_id = $_POST['patient_id'];
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$extension = $_POST['extension'];
		$addr_citymun = $_POST['addr_citymun'];
		$addr_barangay = $_POST['addr_barangay']; 
		$addr_purok = $_POST['addr_purok'];
		$sex = $_POST['sex'];
		$birthdate = $_POST['birthdate'];
		$number = $_POST['number'];
		$email = $_POST['email'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$patient_obj = new patientModel();
		$result = $patient_obj->insert_patient($patient_id, $firstname, $middlename, $lastname, $extension, $addr_citymun, $addr_barangay, $addr_purok, $sex, $birthdate, $number, $email, $user, $datetime);
		echo $result;

	}

}
?>