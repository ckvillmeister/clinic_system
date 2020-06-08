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
      <button class="btn btn-sm btn-secondary" id="collection_btn_print_pdf"><i class="fas fa-file-pdf pr-2"></i>Print PDF</button>
      <button class="btn btn-sm btn-success" id="collection_btn_export_to_excel"><i class="fas fa-file-excel pr-2"></i>Export to Excel</button>
    </div>
  </div>
</div>
<div class="report-content" id="collection_report_content">
  <br>
  <div class="row">
    <div class="col-lg-12 text-center">
      <strong><?php echo $data['system_name']; ?></strong>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 text-center">
      <?php echo $data['address']; ?>
    </div>
  </div>
  <br>

  <div class="row">
    <div class="col-lg-12 text-center">
      <h5><strong>Collection Report</strong></h5>
    </div>
  </div>
  <br>

  <table class="table-report" id="table_collection_report" style="width:100%" border="1">
    <thead>
      <tr>
        <th style="width: 30px" class="text-center">No.</th>
        <th class="text-center">Transaction ID</th>
        <th class="text-center">Total Charge</th>
        <th class="text-center">Paid Amount</th>
        <th class="text-center">Paid By</th>
      </tr>
    </thead>
    <tbody>
    <?php
      $ctr = 0;
      $total_collection = 0;
      foreach ($data['collection'] as $key => $collection) {
        $collection_detail = (object) $collection;
        $patient_detail = (object) $collection_detail->patient_info;
        $total_collection += $collection_detail->total_paid;
    ?>
      <tr>
        <td class="text-center"><?php echo ++$ctr; ?></td>
        <td class="pl-2"><?php echo $collection_detail->transaction_id; ?></td>
        <td class="pl-2"><?php echo number_format($collection_detail->total_charge, 2); ?></td>
        <td class="pl-2"><?php echo number_format($collection_detail->total_paid, 2); ?></td>
        <td class="pl-2"><?php echo trim($patient_detail->firstname).' '.trim($patient_detail->middlename).' '.trim($patient_detail->lastname).' '.trim($patient_detail->extension); ?></td>
      </tr>
    <?php
      }
    ?>
      <tr>
        <td colspan="4" class="pr-2"><div class="float-right">Total Collection:</div></td>
        <td class="pl-2"><strong><?php echo number_format($total_collection, 2); ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>
<script type="text/javascript">
$('#collection_btn_export_to_excel').click(function(){
  $("#table_collection_report").table2excel({
      name: "Collection",
      filename: "Collection Report.xls"
    }); 
});

$('#collection_btn_print_pdf').click(function(){
  var css = '<link rel="stylesheet" href="public/bootstrap/plugins/fontawesome-free/css/all.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/dist/css/adminlte.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">';
  var html = $('#collection_report_content').html();

  var title = 'Collection Report';
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