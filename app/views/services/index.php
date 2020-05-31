<style>
  .content{
    font-family: 'Arial Narrow';
  }

  #modal_service_form{
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
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-wrench"></icon>&nbsp;Services Management</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
            <li class="breadcrumb-item active">Services Management</li>
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
              <button class="btn btn-success btn-sm" id="btn_new_service" style="width:110px"><i class="fas fa-plus-circle"></i>&nbsp;New Service</button>&nbsp;
              <button class="btn btn-primary btn-sm" id="btn_active" style="width:110px"><i class="fas fa-check-circle"></i>&nbsp;Active</button>&nbsp;
              <button class="btn btn-danger btn-sm" id="btn_inactive" style="width:110px"><i class="fas fa-times-circle"></i>&nbsp;Inactive</button>
              <br><br>
              <div id="service_list" class="">

              </div>
            </div>
          </div>
        </div>

      </div>    
    </div>
  </section>
</div>

<!-- Modal Service Form -->
<div class="modal fade" id="modal_service_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-wrench"></icon>&nbsp;Service Information Form</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="form_patient_info">
          <div class="form-group row">
            <div class="col-sm-4">
              <label class="col-form-label">Service Name:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="text_name" placeholder="Service Name">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-4">
              <label class="col-form-label">Description:</label>
            </div>
            <div class="col-sm-8">
              <textarea class="form-control" rows="3" id="text_description" placeholder="Description" style="resize:none;"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-4">
              <label class="col-form-label">Rate:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="text_rate" placeholder="Rate">
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
      <div class="modal-header bg-success">
        <h5><i class="icon fas fa-check"></i><span class="ml-2" id="modal_body_header"></span></h5>
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
