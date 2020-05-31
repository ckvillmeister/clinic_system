<table class="table table-sm table-striped" id="table_patient_list">
  <thead>
    <tr>
      <th style="width:20px" class="text-center">No.</th>
      <th style="width:150px">Patient Full Name</th>
      <th style="width:15px">Control</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $patients = $data['patients'];
      $ctr = 0;
      foreach ($patients as $key => $patient) {
          $patient_detail = (object) $patient;
    ?>
          <tr>
            <td style="width:20px" class="text-center"><?php echo ++$ctr; ?></td>
            <td style="width:150px"><?php echo $patient_detail->firstname.' '.$patient_detail->middlename.' '.$patient_detail->lastname.' '.$patient_detail->extension; ?>
            </td>
            <td style="width:15px">              
              <button class="btn btn-sm btn-success" id="btn_select_patient_control" value="<?php echo $patient_detail->id; ?>"><i class="fas fa-mouse-pointer"></i>&nbsp;Select</button>
            </td>
          </tr>
    <?php
      }
    ?>
  </tbody>
</table>
<script type="text/javascript">
  var dt_patient_list = $('#table_patient_list').DataTable({
                  "ordering": false,
                  "pageLength": 5
              });
</script>