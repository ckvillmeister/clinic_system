<?php

class patientController extends controller{

	public function index(){
		if (!($this->is_session_empty())){
			$patient_obj = new patientModel();
			$muncities = $patient_obj->get_city_mun();
			$this->view()->render('main.php', array('content' => 'patient/index.php', 'muncities' => $muncities, 'system_name' => $this->system_name()));
		}
		else{
			header("Location: ".ROOT);
		}
	}

	public function retrieve_patients(){
		$status = $_POST['status'];

		$patient_obj = new patientModel();
		$patients = $patient_obj->retrieve_patients($status);
		$this->view()->render('patient/patient_list.php', array('patients' => $patients, 'status' => $status));
	}

	public function toggle_patient_status(){
		$id = $_POST['id'];
		$status = $_POST['status'];

		$patient_obj = new patientModel();
		$result = $patient_obj->toggle_patient_status($id, $status);
		echo $result;
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

	public function get_patient_info(){
		$id = $_POST['id'];
		$patient_obj = new patientModel();
		$patient_info = $patient_obj->get_patient_info($id);
		echo json_encode($patient_info);
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
		$remarks = $_POST['remarks'];
		$proceed = $_POST['proceed'];
		$user = $_SESSION['user_id'];
		$datetime = date('Y-m-d H:i:s');

		$patient_obj = new patientModel();
		$result = $patient_obj->insert_patient($patient_id, $firstname, $middlename, $lastname, $extension, $addr_citymun, $addr_barangay, $addr_purok, $sex, $birthdate, $number, $email, $remarks, $user, $datetime, $proceed);

		if ($result == 1 | $result == 2){
			echo $result;
		}
		else{
			$this->view()->render('patient/matched_patient_names.php', array('patient_names' => $result));
		}
	
	}

	public function patient_profile(){
		if (!($this->is_session_empty())){
			$id = $_GET['id'];

			$patient_obj = new patientModel();
			$patient_info = $patient_obj->get_patient_info($id);

			$patient_obj = new patientModel();
			$patient_services_availed = $patient_obj->retrieve_patient_services_availed($id);

			$patient_obj = new patientModel();
			$patient_payments = $patient_obj->retrieve_payment_history($id);

			$patient_obj = new patientModel();
			$no_of_visits = $patient_obj->no_of_visits($id);

			$this->view()->render('main.php', array('content' => 'patient/profile.php', 'patient_info' => $patient_info,  'system_name' => $this->system_name(), 'services_availed' => $patient_services_availed, 'payment_history' => $patient_payments, 'no_of_visits' => $no_of_visits));
		}
		else{
			header("Location: ".ROOT);
		}
	}

}
?>