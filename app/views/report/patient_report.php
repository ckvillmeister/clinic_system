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
      <button class="btn btn-sm btn-secondary" id="patient_btn_print_pdf"><i class="fas fa-file-pdf pr-2"></i>Print PDF</button>
      <button class="btn btn-sm btn-success" id="patient_btn_export_to_excel"><i class="fas fa-file-excel pr-2"></i>Export to Excel</button>
    </div>
  </div>
</div>
<div class="report-content" id="patient_report_content">
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
      <h5><strong>Patient Report</strong></h5>
    </div>
  </div>
  <br>

  <table class="table-report" id="table_patient_report" style="width:100%" border="1">
    <thead>
    <?php
      if ($data['filter'] == ''){
    ?>
      <tr>
        <th style="width: 30px" class="text-center">No.</th>
        <th class="text-center">Patient Name</th>
        <th class="text-center">Address</th>
        <th class="text-center">Sex</th>
        <th class="text-center">Birthdate</th>
        <th class="text-center">Current Age</th>
        <th class="text-center">Contact Number</th>
        <th class="text-center">Medical History Remarks</th>
      </tr>
    <?php
      }
      elseif ($data['filter'] == 1){
    ?>
      <tr>
        <th style="width: 30px" class="text-center">No.</th>
        <th class="text-center">Patient Name</th>
        <th class="text-center">Transaction ID</th>
        <th class="text-center">Total Charge</th>
        <th class="text-center">Discounted Amount</th>
        <th class="text-center">Total Paid</th>
        <th class="text-center">Balance</th>
      </tr>
    <?php
      }
      elseif ($data['filter'] == 2){
    ?>
      <tr>
        <th style="width: 30px" class="text-center">No.</th>
        <th class="text-center">Patient Name</th>
        <th class="text-center">Address</th>
        <th class="text-center">Sex</th>
        <th class="text-center">Birthdate</th>
        <th class="text-center">Current Age</th>
        <th class="text-center">Contact Number</th>
        <th class="text-center">Number of Visits</th>
      </tr>
    <?php
      }
    ?>
    </thead>
    <tbody>
    <?php
      if ($data['filter'] == ''){
        $ctr = 0;
        foreach ($data['patients'] as $key => $patient) {
          $patient_detail = (object) $patient;
    ?>
      <tr>
        <td class="text-center"><?php echo ++$ctr; ?></td>
        <td class="pl-2"><?php echo trim($patient_detail->firstname).' '.trim($patient_detail->middlename).' '.trim($patient_detail->lastname).' '.trim($patient_detail->extension); ?></td>
        <td class="pl-2">
          <?php 
            $address = '';
            if ($patient_detail->address_purok != ''){
              $address .= 'Purok '.$patient_detail->address_purok.', ';
            }

            $address .= ucwords(strtolower($patient_detail->address_brgy_desc).', '.strtolower($patient_detail->address_citymun_desc).', Bohol');
            echo $address;
          ?>  
        </td>
        <td class="text-center"><?php echo ucfirst(strtolower($patient_detail->sex)); ?></td>
        <td class="text-center">
          <?php 
            if (strval($patient_detail->birthdate) != '0000-00-00'){
              echo date('F d, Y',strtotime($patient_detail->birthdate)); 
            }
          ?>  
        </td>
        <td class="text-center">
          <?php 

            if (strval($patient_detail->birthdate) != '0000-00-00'){
              $birthdate = new DateTime($patient_detail->birthdate);
              $today   = new DateTime('today');
              $age = $birthdate->diff($today)->y;
              echo $age;
            }

          ?>
        </td>
        <td class="text-center"><?php echo $patient_detail->contact_number; ?></td>
        <td class="pl-2" style="white-space: pre-line;"><?php echo $patient_detail->remarks; ?></td>
      </tr>
    <?php
        }
      }
      elseif ($data['filter'] == 1){
        $ctr = 0;
        foreach ($data['patients'] as $key => $patient) {
          $patient_detail = (object) $patient;
          $patient_name = (object) $patient_detail->patient_info;
    ?>
      <tr>
        <td class="text-center"><?php echo ++$ctr; ?></td>
        <td class="pl-2"><?php echo trim($patient_name->firstname).' '.trim($patient_name->middlename).' '.trim($patient_name->lastname).' '.trim($patient_name->extension); ?></td>
        <td class="pl-2"><?php echo $patient_detail->transaction_id; ?></td>
        <td class="pl-2"><?php echo number_format($patient_detail->total_amount, 2); ?></td>
        <td class="pl-2"><?php echo number_format($patient_detail->discounted_amount, 2); ?></td>
        <td class="pl-2"><?php echo number_format($patient_detail->total_paid, 2); ?></td>
        <td class="pl-2"><?php echo number_format($patient_detail->balance, 2); ?></td>
      </tr>
    <?php
        }
      }
      elseif ($data['filter'] == 2){
        $ctr = 0;
        foreach ($data['patients'] as $key => $patient) {
          $patient_record = (object) $patient;
          $patient_detail = (object) $patient_record->patient_info;
    ?>
      <tr>
        <td class="text-center"><?php echo ++$ctr; ?></td>
        <td class="pl-2"><?php echo trim($patient_detail->firstname).' '.trim($patient_detail->middlename).' '.trim($patient_detail->lastname).' '.trim($patient_detail->extension); ?></td>
        <td class="pl-2">
          <?php 
            $address = '';
            if ($patient_detail->address_purok != ''){
              $address .= 'Purok '.$patient_detail->address_purok.', ';
            }

            $address .= ucwords(strtolower($patient_detail->address_brgy).', '.strtolower($patient_detail->address_citymun).', Bohol');
            echo $address;
          ?>  
        </td>
        <td class="text-center"><?php echo ucfirst(strtolower($patient_detail->sex)); ?></td>
        <td class="text-center">
          <?php 
            if (strval($patient_detail->birthdate) != '0000-00-00'){
              echo date('F d, Y',strtotime($patient_detail->birthdate)); 
            }
          ?>  
        </td>
        <td class="text-center">
          <?php 

            if (strval($patient_detail->birthdate) != '0000-00-00'){
              $birthdate = new DateTime($patient_detail->birthdate);
              $today   = new DateTime('today');
              $age = $birthdate->diff($today)->y;
              echo $age;
            }

          ?>
        </td>
        <td class="text-center"><?php echo $patient_detail->contact_number; ?></td>
        <td class="text-center"><?php echo $patient_record->no_of_visits; ?></td>
      </tr>
    <?php
        }
      }
    ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
$('#patient_btn_export_to_excel').click(function(){
  $("#table_patient_report").table2excel({
      name: "Patient",
      filename: "Patient Report.xls"
    }); 
});

$('#patient_btn_print_pdf').click(function(){
  var css = '<link rel="stylesheet" href="public/bootstrap/plugins/fontawesome-free/css/all.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/dist/css/adminlte.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">' +
        '<link rel="stylesheet" href="public/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">';
  var html = $('#patient_report_content').html();

  var title = 'Patient Report';
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