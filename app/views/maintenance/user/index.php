<style>
  .content{
    font-family: 'Arial Narrow';
  }

  #modal_user_form{
    font-family: 'Arial Narrow';
  }

  #text_patient_id, #text_age{
    background: #fff;
  }
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-users-cog"></icon>&nbsp;System User Accounts</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">System User Accounts</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">

        <div class="overlay-wrapper">
        
        </div>

        <div class="row-fluid p-2 shadow-none">
          <div class="row">
            <div class="col-lg-12">
              <button class="btn btn-success btn-sm" id="btn_new_user" style="width:110px"><i class="fas fa-user-plus"></i>&nbsp;New User</button>&nbsp;
              <button class="btn btn-primary btn-sm" id="btn_active" style="width:110px"><i class="fas fa-user-check"></i>&nbsp;Active</button>&nbsp;
              <button class="btn btn-danger btn-sm" id="btn_inactive" style="width:110px"><i class="fas fa-user-times"></i>&nbsp;Inactive</button>
              <br><br>
              <div id="user_list" class="">

              </div>
            </div>
          </div>
        </div>

      </div>    
    </div>
  </section>
</div>

<!-- Modal Patient Form -->
<div class="modal fade" id="modal_user_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-user-cog"></icon>&nbsp;User Information Form</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="form_patient_info">
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Username:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="text_username" placeholder="Username">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Password:</label>
            </div>
            <div class="col-sm-3">
              <input type="password" class="form-control" id="text_password" placeholder="Password">
            </div>
          </div>          
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">User Fullname:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="text_firstname" placeholder="Firstname">
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="text_middlename" placeholder="Middlename">
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="text_lastname" placeholder="Lastname">
            </div>
            <div class="col-sm-1">
              <select class="form-control" id="cbo_extension">
                <option value=''></option>
                <option value='JR.'>JR.</option>
                <option value='SR.'>SR.</option>
                <option value='I'>I</option>
                <option value='II'>II</option>
                <option value='III'>III</option>
                <option value='IV'>IV</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Role Type:</label>
            </div>
            <div class="col-sm-3">
              <select class="form-control" id="cbo_accessroles">
                <option value=''></option>
                <?php
                  $roles = $data['roles'];
                  foreach ($roles as $key => $role) {
                    $role_detail = (object) $role;
                  ?>
                    <option value='<?php echo $role_detail->id; ?>'><?php echo $role_detail->name; ?></option>
                  <?php
                  }
                ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="float-right">
          <button class="btn btn-primary" id="btn_submit"><icon class="fas fa-share-square"></icon>&nbsp;Submit</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Message -->
<div class="modal fade" id="modal_message" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="message_modal_header modal-header bg-success">
        <h5><i class="message_icon icon fas fa-check"></i><span class="ml-2" id="modal_body_header"></span></h5>
      </div>
      <div class="modal-body">
        <span id="modal_body_message"></span>
      </div>
    </div>
  </div>
</div>

<!-- Modal Message -->
<div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Confirm</h5>
      </div>
      <div class="modal-body">
        <span id="modal_confirm_message"></span>
      </div>
      <div class="modal-footer">
        <div class="float-right">
          <button class="btn btn-sm btn-primary" id="btn_yes">Yes</button>&nbsp;<button class="btn btn-sm btn-secondary" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
</div>
