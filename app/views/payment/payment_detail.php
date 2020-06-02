<?php
$info = (object) $data['trans_info'];
$patient_info = (object) $info->patient_info;

$fullname = $patient_info->firstname.' '.trim($patient_info->middlename).' '.$patient_info->lastname.' '.trim($patient_info->extension);
$address = ($patient_info->address_purok) ? 'Purok '.$patient_info->address_purok.', ' : '';
$address .= ucwords(strtolower($patient_info->address_brgy.', '.$patient_info->address_citymun.', Bohol'));
$total_amount = 0;
?>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        Billing Detail
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12">
            <span class="text-muted mr-2">Name:</span><strong><?php echo $fullname; ?></strong><br>
            <span class="text-muted mr-2">Address:</span><strong><?php echo $address; ?></strong><br>
            <span class="text-muted mr-2">Contact Number:</span><strong><?php echo $patient_info->contact_number; ?></strong><br><br>
            <div class="col-12 table-responsive">
              <table class="table table-striped" id="table_summary">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Item/Service</th>
                  <th>Type</th>
                  <th>Charge</th>
                  <th>Qty</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    $ctr = 0;
                    foreach ($data['trans_detail'] as $key => $detail) {
                      $detail_info = (object) $detail;
                      $total_amount += $detail_info->total;
                  ?>
                    <tr>
                      <td><?php echo ++$ctr; ?></td>
                      <td><?php echo $detail_info->service_product_info; ?></td>
                      <td><?php echo $detail_info->type; ?></td>
                      <td><?php echo $detail_info->cost; ?></td>
                      <td><?php echo $detail_info->quantity; ?></td>
                      <td><?php echo $detail_info->total; ?></td>
                    </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <strong class="text-muted">Total Amount:</strong>
        <p class="h3"><?php echo number_format($total_amount, 2); ?></p>
        <strong class="text-muted">Remaining Balance:</strong>
        <p class="h3">0.00</p>
        <strong class="text-muted">Discounted Amount:</strong>
        <p class="h3">0.00</p>
      </div>
    </div>
  </div>
</div>

