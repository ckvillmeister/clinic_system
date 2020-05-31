<style type="text/css">
  .controls {
    width: 70px;
  }
</style>
<table class="table table-sm table-striped" id="table_role_list" style="width:100%">
  <thead>
    <tr>
      <th style="width: 100px" class="text-center">No.</th>
      <th>Role Name</th>
      <th>Description</th>
      <th>Added By</th>
      <th style="width:250px">Control</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $roles = $data['roles'];
      $status = $data['status'];
      $ctr = 0;
      foreach ($roles as $key => $role) {
          $role_detail = (object) $role;
    ?>
          <tr>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td><?php echo $role_detail->name; ?></td>
            <td><?php echo $role_detail->description; ?></td>
            <td><span class="badge bg-secondary"><?php echo $role_detail->createdby; ?></span></td>
            <td>
              <?php
                if ($status == 1){
              ?>
              <button class="btn btn-sm btn-warning controls" id="btn_edit_control" value="<?php echo $role_detail->id; ?>"><i class="fas fa-edit"></i>&nbsp;Edit</button>
              <button class="btn btn-sm btn-danger controls" id="btn_delete_control" value="<?php echo $role_detail->id; ?>"><i class="fas fa-trash"></i>&nbsp;Delete</button>
              <a href="<?php echo ROOT; ?>accessrole/patient_profile?id=<?php echo $role_detail->id; ?>" class="btn btn-sm btn-primary controls" id="btn_manage_control" value="<?php echo $role_detail->id; ?>"><i class="fas fa-cog"></i>&nbsp;Rights</a>
              <?php }
                elseif ($status == 0){
              ?>
              <button class="btn btn-sm btn-success controls" id="btn_reactivate_control" value="<?php echo $role_detail->id; ?>" style="width:100px"><i class="fas fa-check"></i>&nbsp;Re-Activate</button>
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
  var dt_role_list = $('#table_role_list').DataTable({
                  "ordering": false,
                  "pageLength": 10,
                  "deferRender": true,
                  "responsive": true,
                  "scrollY": true,
              });
</script>