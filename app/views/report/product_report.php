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
      <button class="btn btn-sm btn-secondary" id="product_btn_print_pdf"><i class="fas fa-file-pdf pr-2"></i>Print PDF</button>
      <button class="btn btn-sm btn-success" id="product_btn_export_to_excel"><i class="fas fa-file-excel pr-2"></i>Export to Excel</button>
    </div>
  </div>
</div>
<div class="report-content" id="product_report_content">
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
      <h5><strong>Dental Products Report</strong></h5>
    </div>
  </div>
  <br>

  <table class="table-report" id="table_product_report" style="width:100%" border="1">
    <thead>
      <tr>
        <th style="width: 30px" class="text-center">No.</th>
        <th class="text-center">Product Name</th>
        <th class="text-center">Description</th>
        <th class="text-center">Unit of Measurement</th>
        <th class="text-center">Price</th>
        <th class="text-center">Quantity on Hand</th>
        <th class="text-center">Re-Order Level</th>
        <?php
          if ($data['filter'] == 1){
        ?>
          <th class="text-center">No. of Times Sold</th>
        <?php
          }
        ?>
      </tr>
    </thead>
    <tbody>
    <?php
      if ($data['filter'] == 1){
        $ctr = 0;
        foreach ($data['products'] as $key => $product) {
          $product_detail = (object) $product;
          $product_data = (object) $product_detail->product_info;
        ?>
          <tr>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td class="pl-2"><?php echo $product_data->name; ?></td>
            <td class="pl-2"><?php echo $product_data->description; ?></td>
            <td class="pl-2"><?php echo $product_data->uom; ?></td>
            <td class="pl-2"><?php echo number_format($product_data->price, 2); ?></td>
            <td class="pl-2"><?php echo $product_data->quantity; ?></td>
            <td class="pl-2"><?php echo $product_data->reorder; ?></td>
            <td class="pl-2"><?php echo $product_detail->times_sold; ?></td>
          </tr>
        <?php
        }
      }
      else{
        $ctr = 0;
        foreach ($data['products'] as $key => $product) {
          $product_detail = (object) $product;
        ?>
          <tr>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td class="pl-2"><?php echo $product_detail->name; ?></td>
            <td class="pl-2"><?php echo $product_detail->description; ?></td>
            <td class="pl-2"><?php echo $product_detail->uom; ?></td>
            <td class="pl-2"><?php echo number_format($product_detail->price, 2); ?></td>
            <td class="pl-2"><?php echo $product_detail->quantity; ?></td>
            <td class="pl-2"><?php echo $product_detail->reorder; ?></td>
          </tr>
        <?php
        }
      }
     
    ?>
    
    </tbody>
  </table>
</div>
<script type="text/javascript">
$('#product_btn_export_to_excel').click(function(){
  $("#table_product_report").table2excel({
      name: "Dental Products",
      filename: "Dental Products Report.xls"
    }); 
});

$('#product_btn_print_pdf').click(function(){
  var css = '<link rel="stylesheet" href="public/bootstrap/plugins/fontawesome-free/css/all.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/dist/css/adminlte.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">';
  var html = $('#product_report_content').html();

  var title = 'Dental Product Report';
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