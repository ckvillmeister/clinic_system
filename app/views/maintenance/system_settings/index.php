<?php
$settings = $data['settings'];
$ctr = 0;

foreach ($settings as $key => $setting) {
  if ($ctr == 0){
    $system_name_detail = (object) $settings[0];
  }
  else if ($ctr == 1){
    $branch_no_detail = (object) $settings[1];
  }
  else if ($ctr == 2){
    $down_payment_detail = (object) $settings[2];
  }
  $ctr++;
}

?>
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
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-cogs"></icon>&nbsp;System Settings</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">System Settings</li>
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

        <div class="row-fluid pt-4 pl-4 pr-3 shadow-none">

          <div class="form-group row">
            <div class="col-sm-2 align-self-center">
                Clinic Name:
            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="text_system_name" value="<?php echo $system_name_detail->desc; ?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-2 align-self-center">
                Branch Number:
            </div>
            <div class="col-sm-6">
                <input type="number" class="form-control" min="1" max="99" id="text_branch_no" value="<?php echo $branch_no_detail->desc; ?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-2 align-self-center">
                Down Payment Percentage:
            </div>
            <div class="col-sm-6">
                <input type="number" class="form-control" min="1" max="99" id="text_dpp" value="<?php echo $down_payment_detail->desc * 100; ?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-12 align-self-center">
              <div class="float-right">
                <button class="btn btn-primary btn-sm" id="btn_submit"><icon class="fas fa-thumbs-up">&nbsp;&nbsp;Submit</icon></button>
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

