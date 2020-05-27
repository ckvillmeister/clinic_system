<?php
	$barangays = $data['barangays'];
	foreach ($barangays as $key => $barangay) {
  		$barangay_detail = (object) $barangay;
?>
  		<option value='<?php echo $barangay_detail->code; ?>'><?php echo $barangay_detail->desc; ?></option>
<?php
	}
?>