<?php
$total_amount = 0;
$balance = 0;
$discount = 0;
$total_paid = 0;
//Transaction Information
$info = (object) $data['trans_info'];

//Patient Information included in the Transaction above
$patient_info = (object) $info->patient_info;

//Patient Fullname
$fullname = $patient_info->firstname.' '.trim($patient_info->middlename).' '.$patient_info->lastname.' '.trim($patient_info->extension);
//Patient Address
$address = ($patient_info->address_purok) ? 'Purok '.$patient_info->address_purok.', ' : '';
$address .= ucwords(strtolower($patient_info->address_brgy.', '.$patient_info->address_citymun.', Bohol'));

?>

<div class="row p-2">
  <div class="col-lg-8">
    <div class="card" id="col_no_1">
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

                    //Collection Info
                    if ($data['collection_info'] == 0){
                      $balance = $total_amount;
                    }
                    else{
                      $collection_info = (object) $data['collection_info'];
                      $discount = $collection_info->discounted_amount;

                      foreach ($data['collection_detail'] as $key => $payment) {
                        $payment_detail = (object) $payment;
                        $total_paid += $payment_detail->amount_paid;
                      }

                      if ($discount == 0 | $discount == ''){
                        $balance = $total_amount - $total_paid;
                      }
                      else{
                        $balance = $discount - $total_paid;
                      }
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
    <div class="card" id="col_no_2">
      <div class="card-body">
        <strong class="text-muted">Total Amount Paid:</strong>
        <p class="h3 text-success"><?php echo number_format($total_paid, 2); ?></p>
        <hr>
        <strong class="text-muted">Actual Total Amount:</strong>
        <p class="h3"><?php echo number_format($total_amount, 2); ?></p>
        <hr>
        <strong class="text-muted">Discounted Amount:</strong>
        <p class="h3" id="discounted_amount"><?php echo number_format($discount, 2); ?></p>
        <hr>
        <strong class="text-muted">Remaining Balance:</strong>
        <p class="h3 text-danger" id="balance_amount"><?php echo number_format($balance, 2); ?></p>
        <hr>
        <strong class="text-muted">Required Down Payment:</strong>
        <p class="h3" id="downpayment_amount">
        <?php
          if ($discount == 0 | $discount == ''){
            $dp = $total_amount * $data['discount_percent'];
            echo number_format($dp, 2);
          }
          else{
            $dp = $discount * $data['discount_percent'];
            echo number_format($dp, 2);
          }
        ?>
        </p><br>
        <div class="row form-group">
          <div class="col-sm-12">
            <?php
              if ($discount == 0 & ($total_amount == $balance)){
            ?>
            <button class="btn btn-sm btn-primary form-control mb-2" id="btn_set_discount"><i class="fas fa-sliders-h mr-2"></i>Set Discount</button>
            <?php
              }
            ?>
            <button class="btn btn-sm btn-success form-control" id="btn_tender_cash"><i class="fas fa-cash-register mr-2"></i>Tender Amount</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="texth_dppercent" value="<?php echo $data['discount_percent']; ?>">
<input type="hidden" id="texth_totalamount" value="<?php echo $total_amount; ?>">
<input type="hidden" id="texth_balance" value="<?php echo $balance; ?>">
<input type="hidden" id="texth_discount">
<input type="hidden" id="texth_dp" value="<?php echo $dp; ?>">
<script type="text/javascript">
  set_height();

  $('#btn_tender_cash').click(function(){
    var row_count = $('#table_summary tbody tr').length;

    if (row_count < 1){
      var header = 'Empty',
      msg = 'Please select transaction first!';
    
      $('#modal_body_header').html(header);
      $('#modal_body_message').html(msg);
      $('.message_modal_header').removeClass('bg-success');
      $('.message_modal_header').addClass('bg-danger');
      $('.message_icon').removeClass('fas fa-check');
      $('.message_icon').addClass('fas fa-times');
      $('#modal_message').modal({
        backdrop: 'static',
          keyboard: false
      });

      setTimeout(function(){ $('#modal_message').modal('toggle'); }, 3000);
    }
    else{
      $("#text_amount").focus();
      $("#modal_tender_cash").modal({
        backdrop: 'static',
          keyboard: false
      });
    }
  });

  $('#btn_set_discount').click(function(){
    $("#modal_set_discount").modal({
        backdrop: 'static',
          keyboard: false
      });
  });

  function set_height(){
    var col_left_height = $("#col_no_1").height(),
        col_right_height = $("#col_no_2").height();

    if (col_left_height > col_right_height){
     $("#col_no_2").css({'height':($("#col_no_1").height()+'px')});
    }
    else if (col_right_height > col_left_height){
      $("#col_no_1").css({'height':(col_right_height+'px')});
    }
  }
</script>

