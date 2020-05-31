<style type="text/css">
  .controls {
    width: 70px;
  }
</style>
<table class="table table-sm table-striped" id="table_service_list" style="width:100%">
  <thead>
    <tr>
      <th style="width: 100px" class="text-center">No.</th>
      <th>Service Name</th>
      <th>Description</th>
      <th>Rate</th>
      <th>Added By</th>
      <th style="width:250px">Control</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $services = $data['services'];
      $status = $data['status'];
      $ctr = 0;
      foreach ($services as $key => $service) {
          $service_detail = (object) $service;
    ?>
          <tr>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td><?php echo $service_detail->name ?></td>
            <td><?php echo $service_detail->description; ?></td>
            <td><?php echo number_format((float)$service_detail->rate, 2, '.', ''); ?></td>
            <td><span class="badge bg-secondary"><?php echo $service_detail->createdby; ?></span></td>
            <td>
              <?php
                if ($status == 1){
              ?>
              <button class="btn btn-sm btn-warning controls" id="btn_edit_control" value="<?php echo $service_detail->id; ?>"><i class="fas fa-edit"></i>&nbsp;Edit</button>
              <button class="btn btn-sm btn-danger controls" id="btn_delete_control" value="<?php echo $service_detail->id; ?>"><i class="fas fa-trash"></i>&nbsp;Delete</button>
              <?php }
                elseif ($status == 0){
              ?>
              <button class="btn btn-sm btn-success controls" id="btn_reactivate_control" value="<?php echo $service_detail->id; ?>" style="width:100px"><i class="fas fa-check"></i>&nbsp;Re-Activate</button>
              <?php
                }
              ?>
            </td>
          </tr>
    <?php
      }
    ?>
  </tbody>
</table>
<script type="text/javascript">
  var dt_service_list = $('#table_service_list').DataTable({
                  "ordering": false,
                  "pageLength": 10,
                  "deferRender": true,
                  "responsive": true,
                  "scrollY": true,
              });
</script>