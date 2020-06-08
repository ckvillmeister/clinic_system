<?php

class reportController extends controller{

	public function index(){
		if (!($this->is_session_empty())){
			$service_obj = new serviceModel();
			$services = $service_obj->retrieve_services(1);
			$this->view()->render('main.php', array('content' => 'report/index.php', 'system_name' => $this->system_name(), 'services' => $services));
		}
		else{
			header("Location: ".ROOT);
		}
	}

	public function transaction_report(){
		$status = $_POST['status'];
		$services = $_POST['services'];
		$months = $_POST['months'];
		$from = $_POST['from'];
		$to = $_POST['to'];

		$report_obj = new reportModel();
		$result = $report_obj->transaction_report($status, $services, $months, $from, $to);

		$this->view()->render('report/transaction_report.php', array('transactions' => $result, 'address' => $this->system_address(), 'system_name' => $this->system_name()));
	}

	public function patient_report(){
		$filter = $_POST['filter'];

		$report_obj = new reportModel();
		$result = $report_obj->patient_report($filter);

		$this->view()->render('report/patient_report.php', array('patients' => $result, 'address' => $this->system_address(), 'filter' => $filter, 'system_name' => $this->system_name()));
	}

	public function product_report(){
		$filter = $_POST['filter'];

		$report_obj = new reportModel();
		$result = $report_obj->product_report($filter);

		$this->view()->render('report/product_report.php', array('products' => $result, 'address' => $this->system_address(), 'filter' => $filter, 'system_name' => $this->system_name()));
	}

	public function collection_report(){
		$month = $_POST['month'];
		$year = $_POST['year'];
		
		$report_obj = new reportModel();
		$result = $report_obj->collection_report($month, $year);

		$this->view()->render('report/collection_report.php', array('collection' => $result, 'address' => $this->system_address(), 'system_name' => $this->system_name()));
	}
}
?>