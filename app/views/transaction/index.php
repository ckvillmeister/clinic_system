<style>
  .patient_information_section{
    font-family: 'Courier New';
  }

  .services_section, .products_section, .transaction_id_section{
    font-family: 'Courier New';
  }

</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-hand-holding-medical"></icon>&nbsp;Dental Service</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
            <li class="breadcrumb-item active">Dental Service</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <div class="card transaction_id_section">
        <div clas="row-fluid p-2 shadow-none">
          <div class="form-group row mt-3 mr-1">
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Trasaction ID:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" id="text_transaction_id" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
            <div class="col-sm-2 text-muted">
              
            </div>
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Date:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" id="text_date" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
          </div>
        </div>
      </div>

      <div class="card patient_information_section">
        <div class="row-fluid p-2 shadow-none">
          
          <div class="row">
            <div class="col-sm-3 text-center">
              
            </div>
            <div class="col-sm-6">
              <div class='text-center'>
                <strong style='font-size: 16pt'><?php echo $data['system_name']; ?></strong><br>
                Poblacion, Talibon, Bohol
              </div>
            </div>
            <div class="col-sm-3">
              
            </div>
          </div>

          <hr>
          
          <div class="row">
            <div class="col-sm-12">
              <div class="text-center h4">
                <strong>Patient Information</strong>
                <button class="btn btn-sm btn-primary float-right mr-3" id="btn_search"><i class='fas fa-search'></i></button>
              </div>
            </div>
          </div><br>
          <div class="form-group row">
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Patient ID:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" id="text_patient_id" class="form-control form-control-sm bg-white" readonly="readonly">
              <input type="hidden" id="text_id">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Patient Name:</label>
            </div>
            <div class="col-sm-5">
              <input type="text" id="text_fullname" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Sex:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" id="text_sex" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Address:</label>
            </div>
            <div class="col-sm-5">
              <input type="text" id="text_address" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Birthdate:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" id="text_birthdate" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Contact Number:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" id="text_contact_number" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
            <div class="col-sm-1 text-muted">
              <label class="col-form-label ml-3">Email:</label>
            </div>
            <div class="col-sm-3">
              <input type="text" id="text_email" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
            <div class="col-sm-1 text-muted">
              <label class="col-form-label ml-3">Age:</label>
            </div>
            <div class="col-sm-2">
              <input type="text" id="text_age" class="form-control form-control-sm bg-white" readonly="readonly">
            </div>
          </div>
        </div>

      </div>  

      <div class="card services_section">
        <div class="row-fluid p-2 shadow-none">

          <div class="row mt-3">
            <div class="col-sm-12">
              <div class="text-center h4">
                <strong class="pr-5">Services Section</strong>
              </div>
            </div>
          </div><br>

          <div class="form-group row">
            <div class="col-sm-2 text-muted">
              <label class="col-form-label ml-3">Services:</label>
            </div>
            <div class="col-sm-3">
              <select id="cbo_services" class="form-control form-control-sm bg-white">
                <option value=""></option>
              <?php
                $services = $data['services'];
                foreach ($services as $key => $service) {
                  $service_detail = (object) $service;
              ?>
                <option value="<?php echo $service_detail->id; ?>"><?php echo $service_detail->name; ?></option>
              <?php
                }
              ?>
              </select>
            </div>
          </div>

          <div class="form-group row p-3">
            <div class="col-sm-12">
              <table class="table table-sm table-striped border border-light" id="table_services_availed" style="width:100%">
                <thead>
                  <tr>
                    <th style="display:none"></th>
                    <th>No.</th>
                    <th>Service Name</th>
                    <th>Prescription</th>
                    <th>Remarks</th>
                    <th>Charge</th>
                    <th style="width:200px">Control</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

      <div class="card products_section">
        <div class="row-fluid p-2 shadow-none">

          <div class="row mt-3">
            <div class="col-sm-12">
              <div class="text-center h4">
                <strong class="">Dental Products Section</strong>
                <button class="btn btn-sm btn-primary float-right mr-3" id="btn_search_product"><i class='fas fa-search'></i></button>
              </div>
            </div>
          </div><br>

          <div class="form-group row pr-3 pl-3">
            <div class="col-sm-12">
              <table class="table table-sm table-striped" id="table_products_ordered" style="width:100%">
                <thead>
                  <tr>
                    <th style="display:none"></th>
                    <th>No.</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Control</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>

      <div class="card">
        <div clas="row-fluid p-2 shadow-none">
          <div class="form-group row mt-3">
            <div class="col-sm-12">
              <div class="float-right mr-4">
                <button class="btn btn-sm btn-primary" id="btn_confirm"><i class="fas fa-clipboard-check mr-2"></i>Confirm</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<!-- Modal Patient List -->
<div class="modal fade" id="modal_patient_list" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="overlay-wrapper"></div>
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-list-alt"></icon>&nbsp;Registered Patient List</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="patient_list">

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Service Form -->
<div class="modal fade" id="modal_service_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="overlay-wrapper"></div>
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-hand-holding-medical"></icon>&nbsp;Dental Service Form</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <div class="patient_information_section">
          <div class="row-fluid p-2 shadow-none">    
            
            <div class="row">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <div class='text-center'>
                  <strong style='font-size: 16pt'>DR. WENDELL GARAY</strong><br>
                  <span style='font-size: 14pt'>Dental Clinic</span><br>
                  Poblacion, Talibon, Bohol
                </div>
              </div>
              <div class="col-sm-2"></div>
            </div><br>
            
            <div class="form-group row">
              <div class="col-sm-3">
                <label class="col-form-label">Service Name:</label>
              </div>
              <div class="col-sm-4">
                <input type="text" id="text_service_name" class="form-control form-control-sm bg-white" readonly="readonly">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-3">
                <label class="col-form-label">Prescription:</label>
              </div>
              <div class="col-sm-9">
                <textarea class="form-control" rows="5" id="text_prescription" placeholder="Prescription" style="resize:none;"></textarea>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-3">
                <label class="col-form-label">Remarks:</label>
              </div>
              <div class="col-sm-9">
                <textarea class="form-control" rows="3" id="text_remarks" placeholder="Remarks" style="resize:none;"></textarea>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-3">
                <label class="col-form-label">Charge:</label>
              </div>
              <div class="col-sm-4">
                <input type="text" id="text_charge" class="form-control form-control-sm bg-white" readonly="readonly">
              </div>
            </div>

          </div>
        </div>

      </div>
      <div class="modal-footer">
        <div class="float-right">
          <button class="btn btn-sm btn-primary" id="btn_add_service"><i class="fas fa-plus mr-2"></i>Add</button>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Modal Product List -->
<div class="modal fade" id="modal_product_list" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="overlay-wrapper"></div>
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-tooth"></icon>&nbsp;Dental Product List</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="product_list">

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Quantity -->
<div class="modal fade" id="modal_quantity" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="overlay-wrapper"></div>
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-clock"></icon>&nbsp;Number of Products to Order</h4></strong>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-8">
            <input type="text" id="text_number_of_products" class="form-control form-control-sm mr-2" placeholder="Number of Products">
          </div>
          <div class="col-sm-4">
            <button class="btn btn-sm btn-primary" id="btn_add_product"><i class="fas fa-plus-circle mr-2"></i>Add</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Summary -->
<div class="modal fade" id="modal_summary" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5><i class="fas fa-file-invoice mr-2"></i>Invoice</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
        <div class="invoice p-3 mb-3">
          <div id="to_print">
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe mr-2"></i><span id="span_clinic_name"><?php echo $data['system_name']; ?></span>
                  <small class="float-right"> <span class="text-muted pr-3">Date:</span><span id="span_date"></span></small>
                </h4>
              </div>
            </div><br>
          
            <div class="row invoice-info">
              <div class="col-sm-6 invoice-col">
                <span class="text-muted pr-3">Transaction ID:</span><b><span id="span_transaction_id"></span></b><br>
                <br>
                <span class="text-muted pr-3">Patient ID:</span><b><span id="span_patient_id"></span></b><br>
                <span class="text-muted pr-3">Patient Fullname:</span><b><span id="span_fullname"></span></b><br>
                <span class="text-muted pr-3">Address:</span><b><span id="span_address"></span></b><br>
              </div>
              <div class="col-sm-4 invoice-col">
                <span class="text-muted"></span><br>
                <br>
                <span class="text-muted pr-3">Sex:</span><b><span id="span_sex"></span></b><br>
                <span class="text-muted pr-3">Age:</span><b><span id="span_age"></span></b><br>
                <span class="text-muted pr-3">Contact Number:</span><b><span id="span_contact_number"></span></b><br>
              </div>
            </div><br>

            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped" id="table_summary">
                  <thead>
                  <tr>
                    <th style="display: none"></th>
                    <th>No.</th>
                    <th>Item/Service</th>
                    <th>Type</th>
                    <th>Charge</th>
                    <th>Qty</th>
                    <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row">

              <div class="col-6">
                
              </div>

              <div class="col-6">
                <p class="lead">Amount Due:</p>

                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <th style="width:50%">Subtotal:</th>
                      <td><span id="span_sub_total"></span></td>
                    </tr>
                    <tr>
                      <th>Required Downpayment:</th>
                      <td><span id="span_required_dp"></span></td>
                    </tr>
                    <tr>
                      <th>Discount:</th>
                      <td><span id="span_discount_price"></span></td>
                    </tr>
                    <tr>
                      <th>Total:</th>
                      <td><span id="span_grand_total"></span></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="row no-print">
            <div class="col-12">
              <button type="button" id="btn_save_transaction" class="btn btn-success float-right" style="width:180px"><i class="far fa-credit-card"></i> Save Transaction
              </button>
              <button type="button" id="btn_print_bill" class="btn btn-primary float-right mr-2" style="width:180px"><i class="fas fa-print"></i> Print</button>
            </div>
          </div>
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

<!-- Modal Connfirm Message -->
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
