<style type="text/css">
  .controls {
    width: 70px;
  }
  .table-report {
    font-size: 12pt;
  }
  .table-report, th, td {
    border-color: #adaaa8;
  }
  .report-content{
    font-family: 'Arial Narrow';
  }
</style>
<div class="row">
  <div class="col-lg-12">
    <div class="float-right">
      <button class="btn btn-sm btn-secondary" id="transaction_btn_print_pdf"><i class="fas fa-file-pdf pr-2"></i>Print PDF</button>
      <button class="btn btn-sm btn-success" id="transaction_btn_export_to_excel"><i class="fas fa-file-excel pr-2"></i>Export to Excel</button>
    </div>
  </div>
</div>
<div class="report-content" id="transaction_report_content">
  <br>
  <div class="row">
    <div class="col-lg-12 text-center">
      <strong><?php echo $data['system_name']; ?></strong>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 text-center">
      Poblacion, Talibon, Bohol
    </div>
  </div>
  <br>

  <div class="row">
    <div class="col-lg-12 text-center">
      <h5><strong>Transaction (Services) Report</strong></h5>
    </div>
  </div>
  <br>

  <table class="table-report" id="table_transaction_report" style="width:100%" border="1">
    <thead>
      <tr>
        <th style="width: 30px" class="text-center">No.</th>
        <th class="text-center">Transaction ID</th>
        <th class="text-center">Date</th>
        <th class="text-center">Patient Name</th>
        <th class="text-center">Services Availed</th>
        <th class="text-center">Remarks</th>
        <th class="text-center">Status</th>
      </tr>
    </thead>
    <tbody>
    <?php
      $ctr = 0;
      foreach ($data['transactions'] as $key => $transaction) {
        $transaction_detail = (object) $transaction;
        $new_date =date('F d, Y',strtotime($transaction_detail->date));
        
    ?>
      <tr>
        <td class="text-center"><?php echo ++$ctr; ?></td>
        <td class="pl-2"><?php echo $transaction_detail->transaction_id; ?></td>
        <td class="pl-2"><?php echo $new_date; ?></td>
        <td class="pl-2">
          <?php  
            $patient_detail = (object) $transaction_detail->patient_name;
            echo trim($patient_detail->firstname).' '.trim($patient_detail->middlename).' '.trim($patient_detail->lastname).' '.trim($patient_detail->extension);
          ?>
        </td>
        <td class="pl-2">
          <?php  
            foreach ($transaction_detail->services_availed as $key => $service) {
              $service_detail = (object) $service;
              echo '&#8226; ';
              echo $service_detail->name.' - '.$service_detail->description;
              echo '<br>';
            }
          ?>  
        </td>
        <td class="pl-2">
          <?php  
            foreach ($transaction_detail->services_availed as $key => $service) {
              $service_detail = (object) $service;
              echo '<span style="white-space: pre-line;">';
              echo '&#8226; ';
              echo $service_detail->remarks;
              echo '</span>';
              echo '<br>';
            }
          ?>  
        </td>
        <td class="text-center pr-2 pl-2">
          <?php  
            if ($transaction_detail->status == 0){
              echo 'Voided';
            }
            elseif ($transaction_detail->status == 1){
              echo 'Active';
            }
            elseif ($transaction_detail->status == 2){
              echo 'Closed';
            }
          ?>
        </td>
      </tr>
    <?php
      }
    ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
$('#transaction_btn_export_to_excel').click(function(){
  $("#table_transaction_report").table2excel({
      name: "Services",
      filename: "Services Transaction Report.xls" //do not include extension
      //fileext: ".xlsx" // file extension
    }); 
});

$('#transaction_btn_print_pdf').click(function(){
  var css = '<link rel="stylesheet" href="public/bootstrap/plugins/fontawesome-free/css/all.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/dist/css/adminlte.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">';
  var html = $('#transaction_report_content').html();

  var title = 'Services Transaction Report';
  var params = [
        'height='+screen.height,
        'width='+screen.width,
        'fullscreen=yes' 
    ].join(',');
    var mywindow = window.open('', title, params);
    mywindow.document.write(css);
    mywindow.document.write(html);
    mywindow.document.write(js);
    mywindow.document.write('<title>' + title + '</title>');
    setTimeout(function(){ mywindow.print(); }, 1000);
});
  
</script>