<style type="text/css">
  .controls {
    width: 70px;
  }
</style>
<table class="table table-sm table-striped" id="table_patient_list" style="width:100%">
  <thead>
    <tr>
      <th style="width: 100px" class="text-center">No.</th>
      <th>Patient Full Name</th>
      <th>Added By</th>
      <th style="width:250px">Control</th>
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
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td><?php echo $patient_detail->firstname.' '.$patient_detail->middlename.' '.$patient_detail->lastname.' '.$patient_detail->extension; ?></td>
            <td><span class="badge bg-primary"><?php echo $patient_detail->createdby; ?></span></td>
            <td>
              <button class="btn btn-sm btn-warning controls" id="btn_edit_control" value="<?php echo $patient_detail->id; ?>"><i class="fas fa-edit"></i>&nbsp;Edit</button>
              <button class="btn btn-sm btn-danger controls" id="btn_delete_control" value="<?php echo $patient_detail->id; ?>"><i class="fas fa-trash"></i>&nbsp;Delete</button>
              <button class="btn btn-sm btn-primary controls" id="btn_view_control" value="<?php echo $patient_detail->id; ?>"><i class="fas fa-eye"></i>&nbsp;View</button>
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
                  "pageLength": 10,
                  "deferRender": true,
                  "responsive": true,
                  "scrollY": true,
              });
</script>