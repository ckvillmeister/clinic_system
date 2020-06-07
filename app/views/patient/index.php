
<style>
  .content{
    font-family: 'Arial Narrow';
  }

  #modal_patient_form{
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
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-id-card-alt"></icon>&nbsp;Patient Records</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Patient Records</li>
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
              <button class="btn btn-success btn-sm" id="btn_new_patient" style="width:110px"><i class="fas fa-user-plus"></i>&nbsp;New Patient</button>&nbsp;
              <button class="btn btn-primary btn-sm" id="btn_active" style="width:110px"><i class="fas fa-user-check"></i>&nbsp;Active</button>&nbsp;
              <button class="btn btn-danger btn-sm" id="btn_inactive" style="width:110px"><i class="fas fa-user-times"></i>&nbsp;Inactive</button>
              <br><br>
              <div id="patient_list" class="">

              </div>
            </div>
          </div>
        </div>

      </div>    
    </div>
  </section>
</div>

<!-- Modal Patient Form -->
<div class="modal fade" id="modal_patient_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-user-tag"></icon>&nbsp;Patient Information Form</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="form_patient_info">
          <div class="row">
            <div class="col-sm-2">
              <label class="col-form-label">Patient ID No.:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="text_patient_id" placeholder="Patient ID Number" readonly="readonly">
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Patient Fullname:</label>
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
              <label class="col-form-label">Address:</label>
            </div>
            <div class="col-sm-4">
              <select class="form-control" id="cbo_muncity">
                <option value=''>[ City / Municipality ]</option>
                <?php
                  $mun_cities = $data['muncities'];
                  foreach ($mun_cities as $key => $mun_city) {
                    $mun_city_detail = (object) $mun_city;
                  ?>
                    <option value='<?php echo $mun_city_detail->code; ?>'><?php echo $mun_city_detail->desc; ?></option>
                  <?php
                  }
                ?>
              </select>
            </div>
            <div class="col-sm-4">
              <select class="form-control" id="cbo_brgy">
                <option value=''>[ Barangay ]</option>
              </select>
            </div>
            <div class="col-sm-2">
              <select class="form-control" id="cbo_purok">
                <option value=''>[ Purok ]</option>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
                <option value='6'>6</option>
                <option value='7'>7</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Sex:</label>
            </div>
            <div class="col-sm-3">
              <select class="form-control" id="cbo_sex">
                <option value=''></option>
                <option value='MALE'>MALE</option>
                <option value='FEMALE'>FEMALE</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Birthdate:</label>
            </div>
            <div class="col-sm-3">
              <input type="date" class="form-control" id="text_birthdate" placeholder="Birthdate">
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="text_age" placeholder="Current Age" readonly="readonly">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Contact Details:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" id="text_number" placeholder="Contact Number">
            </div>
            <div class="col-sm-3">
              <input type="email" class="form-control" id="text_email" placeholder="E-mail">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2">
              <label class="col-form-label">Medical History Remarks:</label>
            </div>
            <div class="col-sm-10">
              <textarea id="text_medical_history_remarks" rows="2" style="resize:none;" class="form-control form-control-sm bg-white"></textarea>
            </div>
          </div>
        </div>
      </form>
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

<!-- Modal Confirm -->
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

<!-- Modal Matching Patient Name -->
<div class="modal fade" id="modal_matching_patient_name" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Confirm</h5>
      </div>
      <div class="modal-body">
        <div id="match_patient_name_list">
        </div>
      </div>
      <div class="modal-footer">
        <div class="float-right">
          <button class="btn btn-sm btn-primary" id="btn_proceed">Proceed</button>&nbsp;<button class="btn btn-sm btn-secondary" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
</div>
