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
              <img class="profile-user-img img-fluid img-circle" src="<?php echo ROOT; ?>public/image/system_logo.jpg" width="250px" height="100px">
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
                  <strong style='font-size: 16pt'><?php echo $data['system_name']; ?></strong><br>
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


<!-- Modal Summary -->
<div class="modal fade" id="modal_summary" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5><i class="fas fa-file-invoice mr-2"></i>Summary</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
         <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> AdminLTE, Inc.
                <small class="float-right">Date: 2/10/2014</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong>Admin, Inc.</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                Phone: (804) 123-5432<br>
                Email: info@almasaeedstudio.com
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              To
              <address>
                <strong>John Doe</strong><br>
                795 Folsom Ave, Suite 600<br>
                San Francisco, CA 94107<br>
                Phone: (555) 539-1037<br>
                Email: john.doe@example.com
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Invoice #007612</b><br>
              <br>
              <b>Order ID:</b> 4F3S8J<br>
              <b>Payment Due:</b> 2/22/2014<br>
              <b>Account:</b> 968-34567
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Qty</th>
                  <th>Product</th>
                  <th>Serial #</th>
                  <th>Description</th>
                  <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>1</td>
                  <td>Call of Duty</td>
                  <td>455-981-221</td>
                  <td>El snort testosterone trophy driving gloves handsome</td>
                  <td>$64.50</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Need for Speed IV</td>
                  <td>247-925-726</td>
                  <td>Wes Anderson umami biodiesel</td>
                  <td>$50.00</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Monsters DVD</td>
                  <td>735-845-642</td>
                  <td>Terry Richardson helvetica tousled street art master</td>
                  <td>$10.70</td>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Grown Ups Blue Ray</td>
                  <td>422-568-642</td>
                  <td>Tousled lomo letterpress</td>
                  <td>$25.99</td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
              <p class="lead">Payment Methods:</p>
              <img src="../../dist/img/credit/visa.png" alt="Visa">
              <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
              <img src="../../dist/img/credit/american-express.png" alt="American Express">
              <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

              <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                plugg
                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
              </p>
            </div>
            <!-- /.col -->
            <div class="col-6">
              <p class="lead">Amount Due 2/22/2014</p>

              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td>$250.30</td>
                  </tr>
                  <tr>
                    <th>Tax (9.3%)</th>
                    <td>$10.34</td>
                  </tr>
                  <tr>
                    <th>Shipping:</th>
                    <td>$5.80</td>
                  </tr>
                  <tr>
                    <th>Total:</th>
                    <td>$265.24</td>
                  </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
              <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
              <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                Payment
              </button>
              <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
              </button>
            </div>
          </div>
          </div>
      </div>
    </div>
  </div>
</div>
