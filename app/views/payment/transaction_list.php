<table class="table table-sm table-striped" id="table_transaction_list" style="width:100%">
  <thead>
    <tr>
      <th style="width: 30px" class="text-center">No.</th>
      <th>Transaction ID</th>
      <th style="width:150px">Patient Name</th>
      <th style="width:50px">Control</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $ctr = 0;
      foreach ($data['transactions'] as $key => $transaction) {
          $transaction_detail = (object) $transaction;
          $patient_info = (object) $transaction_detail->patient_info;
          $fullname = $patient_info->firstname.' '.trim($patient_info->middlename).' '.$patient_info->lastname.' '.trim($patient_info->extension);
        ?>
          <tr>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td><?php echo $transaction_detail->transaction_id; ?></td>
            <td><?php echo $fullname; ?></td>
            <td>
              <button class="btn btn-sm btn-success controls" id="btn_select" value="<?php echo $transaction_detail->id; ?>" style="width:100px"><i class="fas fa-check"></i>&nbsp;Select</button>
            </td>
          </tr>
        <?php
          }
        ?>
  </tbody>
</table>
<script type="text/javascript">
  var dt_product_list = $('#table_transaction_list').DataTable({
                  "ordering": false,
                  "pageLength": 10,
                  "deferRender": true
              });
</script>