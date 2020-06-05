<span>The following are name of patients that matches with your new entry:</span><br><br>
<?php
$ctr = 1;
foreach ($data['patient_names'] as $key => $patient) {
	$patient_detail = (object) $patient;
?>
	<span><strong><?php echo $ctr.'. '.trim($patient_detail->firstname).' '.trim($patient_detail->middlename).' '.trim($patient_detail->lastname).' '.trim($patient_detail->extension); ?></strong></span><br>
<?php
$ctr++;
}
?>
<br><br><span>Do you want to proceed?</span>