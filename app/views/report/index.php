<style>
  select, button{
    height:30px;
  }

  select{
    width: 150px;
  }
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-list"></icon>&nbsp;Reports</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
            <li class="breadcrumb-item active">Reports</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="overlay-wrapper"></div>

      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#tab_transactions" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Transactions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#tab_patients" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Patients</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#tab_products" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Products</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade show active" id="tab_transactions" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">

              <div class="row-fluid p-2 shadow-none">
                <div class="row">
                  <div class="col-lg-12">

                    <div class="row">
                      <select class="form-group form-group-sm mr-2">
                        <option value=""> [ Status ] </option>
                      </select>
                      <select class="form-group form-group-sm mr-2">
                        <option value=""> [ Service Type ] </option>
                      </select>
                      <button class="btn btn-sm btn-primary form-group form-group-sm"><i class="fas fa-recycle mr-2"></i>Generate</button>
                    </div>

                    <div id="transaction_list" class="">

                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="tab_patients" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">

              <div class="row-fluid p-2 shadow-none">
                <div class="row">
                  <div class="col-lg-12">

                    <div class="row">
                      <select class="form-group form-group-sm mr-2">
                        <option value=""> [ Status ] </option>
                      </select>
                      <select class="form-group form-group-sm mr-2">
                        <option value=""> [ Balance ] </option>
                      </select>
                      <button class="btn btn-sm btn-primary form-group form-group-sm"><i class="fas fa-recycle mr-2"></i>Generate</button>
                    </div>

                    <div id="patient_list" class="">

                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="tab_products" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">

              <div class="row-fluid p-2 shadow-none">
                <div class="row">
                  <div class="col-lg-12">

                    <div class="row">
                      <select class="form-group form-group-sm mr-2">
                        <option value=""> [ Status ] </option>
                      </select>
                      <select class="form-group form-group-sm mr-2">
                        <option value=""> [ Balance ] </option>
                      </select>
                      <button class="btn btn-sm btn-primary form-group form-group-sm"><i class="fas fa-recycle mr-2"></i>Generate</button>
                    </div>

                    <div id="patient_list" class="">

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

<!-- Modal Product Form -->
<div class="modal fade" id="modal_product_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-tooth"></icon>&nbsp;Product Information Form</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="form_patient_info">
          <div class="form-group row">
            <div class="col-sm-4">
              <label class="col-form-label">Product Name:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="text_name" placeholder="Product Name">
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
              <label class="col-form-label">Price:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="text_price" placeholder="Price">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-4">
              <label class="col-form-label">Quantity on Hand:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="text_quantity" placeholder="Quantity on Hand">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-4">
              <label class="col-form-label">Re-order Level:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="text_reorder" placeholder="Re-order Level">
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
