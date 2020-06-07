<style type="text/css">
  .controls {
    width: 70px;
  }
</style>
<table class="table table-sm table-striped" id="table_user_list" style="width:100%">
  <thead>
    <tr>
      <th style="width: 100px" class="text-center">No.</th>
      <th>User Fullname</th>
      <th>Username</th>
      <th>Role</th>
      <th>Added By</th>
      <th style="width:250px">Control</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $users = $data['users'];
      $status = $data['status'];
      $ctr = 0;
      foreach ($users as $key => $user) {
          $user_detail = (object) $user;
    ?>
          <tr>
            <td class="text-center"><?php echo ++$ctr; ?></td>
            <td><?php  echo $user_detail->firstname.' '.$user_detail->middlename.' '.$user_detail->lastname.' '.$user_detail->extension; ?></td>
            <td><?php echo $user_detail->username; ?></td>
            <td><?php echo $user_detail->role; ?></td>
            <td><span class="badge bg-secondary"><?php echo $user_detail->createdby; ?></span></td>
            <td>
              <?php
                if ($status == 1){
              ?>
              <button class="btn btn-sm btn-warning controls" id="btn_edit_control" value="<?php echo $user_detail->id; ?>"><i class="fas fa-edit"></i>&nbsp;Edit</button>
              <button class="btn btn-sm btn-danger controls" id="btn_delete_control" value="<?php echo $user_detail->id; ?>"><i class="fas fa-trash"></i>&nbsp;Delete</button>
              <a href="<?php echo ROOT; ?>user/view_user_profile?id=<?php echo $user_detail->id; ?>" class="btn btn-sm btn-primary controls" id="btn_view_control" value="<?php echo $user_detail->id; ?>"><i class="fas fa-eye"></i>&nbsp;View</a>
              <?php }
                elseif ($status == 0){
              ?>
              <button class="btn btn-sm btn-success controls" id="btn_reactivate_control" value="<?php echo $user_detail->id; ?>" style="width:100px"><i class="fas fa-check"></i>&nbsp;Re-Activate</button>
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
  var dt_user_list = $('#table_user_list').DataTable({
                  "ordering": false,
                  "pageLength": 10,
                  "deferRender": true,
                  "responsive": true,
                  "scrollY": true,
              });
</script>