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
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-id-badge"></icon>&nbsp;User Profile</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>user">System User Accounts</a></li>
            <li class="breadcrumb-item active">User Profile</li>
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
              <h4 class="ml-2"><i class="fas fa-user mr-3"></i>User Profile & Settings</h4>
            <div class="row">
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="btn_profile" data-toggle="pill" href="#tab_profile" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Profile</a>
                  <a class="nav-link" id="btn_change_password" data-toggle="pill" href="#tab_change_password" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Change Password</a>
                  <a class="nav-link" id="btn_reset_password" data-toggle="pill" href="#tab_reset_password" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Reset Password</a>
                </div>
              </div>
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                  <div class="tab-pane text-left fade show active" id="tab_profile" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                    
                    <div class="m-3 border border-primary p-5 rounded">
                      <?php 
                        $user_detail = (object) $data['user_info'];
                      ?>

                      <div class="row form-group">
                        <div class="col-sm-12 text-center">
                          <h3><strong><i class="fas fa-user pr-2"></i>User Profile</strong></h3>
                        </div>
                      </div><br>

                      <div class="row form-group">
                        <div class="col-sm-2">
                          Name:
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm bg-white" value="<?php echo trim($user_detail->firstname).' '.trim($user_detail->middlename).' '.trim($user_detail->lastname).' '.trim($user_detail->extension); ?>" readonly="readonly">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-sm-2">
                          Username:
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm bg-white" value="<?php echo $user_detail->username; ?>" readonly="readonly">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-sm-2">
                          Role:
                        </div>
                        <div class="col-sm-6">
                          <input type="text" class="form-control form-control-sm bg-white" value="<?php echo $user_detail->role_name; ?>" readonly="readonly">
                        </div>
                      </div>

                    </div>

                  </div>
                  <div class="tab-pane fade" id="tab_change_password" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                     
                    <div class="m-3 border border-primary p-5 rounded">  

                      <div class="row form-group">
                        <div class="col-sm-12 text-center">
                          <h3><strong><i class="fas fa-key pr-2"></i>Change Password</strong></h3>
                        </div>
                      </div><br>

                      <div class="row form-group">
                        <div class="col-sm-3">
                          Old Password:
                        </div>
                        <div class="col-sm-6">
                          <input type="password" id="text_old_password" class="form-control form-control-sm">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-sm-3">
                          New Password:
                        </div>
                        <div class="col-sm-6">
                          <input type="password" id="text_new_password" class="form-control form-control-sm">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-sm-3">
                          Confirm Password:
                        </div>
                        <div class="col-sm-6">
                          <input type="password" id="text_confirm_password" class="form-control form-control-sm">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-sm-9">
                          <div class="float-right">
                            <button class="btn btn-sm btn-primary" id="btn_change_pass">Submit</button>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>
                  <div class="tab-pane fade" id="tab_reset_password" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                    
                    <div class="m-3 border border-primary p-5 rounded">  

                      <div class="row form-group">
                        <div class="col-sm-12 text-center">
                          <h3><strong><i class="fas fa-sync-alt pr-2"></i>Reset Password</strong></h3>
                        </div>
                      </div><br>

                      <div class="row form-group">
                        <div class="col-sm-3">
                          New Password:
                        </div>
                        <div class="col-sm-6">
                          <input type="password" id="text_reset_new_password" class="form-control form-control-sm">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-sm-3">
                          Confirm Password:
                        </div>
                        <div class="col-sm-6">
                          <input type="password" id="text_reset_confirm_password" class="form-control form-control-sm">
                        </div>
                      </div>

                      <div class="row form-group">
                        <div class="col-sm-9">
                          <div class="float-right">
                            <button class="btn btn-sm btn-primary" id="btn_reset_pass">Submit</button>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>

      </div>    
    </div>
  </section>
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




