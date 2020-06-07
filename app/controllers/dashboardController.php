<?php

class dashboardController extends controller{

	public function index(){	
		if (!($this->is_session_empty())){
			$dashboard_obj = new dashboardModel();

			$users = $dashboard_obj->count_records('tbl_users');
			$patients = $dashboard_obj->count_records('tbl_patient_information');
			$products = $dashboard_obj->count_records('tbl_products');
			$balances = $dashboard_obj->count_patients_with_balance();

			$this->view()->render('main.php', array('content' => 'dashboard/index.php', 'users' => $users, 'patients' => $patients, 'products' => $products, 'balances' => $balances, 'system_name' => $this->system_name()));
		}
		else{
			header("Location: http://localhost".ROOT);
		}
	}

	public function retrieve_patients_stats(){
		$dashboard_obj = new dashboardModel();
		$result = $dashboard_obj->retrieve_patients_stats();
		echo json_encode($result);
	}

	public function retrieve_collection_stats(){
		$dashboard_obj = new dashboardModel();
		$result = $dashboard_obj->retrieve_collection_stats();
		echo json_encode($result);
	}
}
?>