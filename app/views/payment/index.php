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
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-money-bill-wave"></icon>&nbsp;Payment</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Payment</li>
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

        <div class="row-fluid p-2 shadow-none" >
        
          <div class="row p-2">
            <div class="col-lg-3">
              <input type="text" class="form-control form-control-sm" id="text_transaction_id" placeholder="Transaction ID">
            </div>
            <div class="col-lg-2">
              <button class="btn btn-primary btn-sm" id="btn_search" style="width:35px">
                <i class="fas fa-search"></i>
              </button>  
              <button class="btn btn-secondary btn-sm" id="btn_transaction_list" style="width:35px">
                <i class="fas fa-list-alt"></i>
              </button>
              <input type="hidden" id="text_transaction_sys_id">
              <input type="hidden" id="texth_transaction_id">
            </div>
          </div><br>

          <div id="payment_detail">
          </div>
        </div>
      </div>    
    </div>
  </section>
</div>

<!-- Modal Transaction List -->
<div class="modal fade" id="modal_transaction_list" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-list-alt"></icon>&nbsp;Transactions List</strong></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="transaction_list">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tender Cash List -->
<div class="modal fade" id="modal_tender_cash" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-money-bill"></icon>&nbsp;Tender Amount</strong></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-9">
              <input type="text" class="form-control form-control-sm" id="text_amount" placeholder="Enter Payment Amount">
            </div>
            <div class="col-sm-2">
              <button class="btn btn-sm btn-primary" id="btn_enter_payment_amount">Enter</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Set Discount -->
<div class="modal fade" id="modal_set_discount" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_title"><strong><icon class="fas fa-percentage"></icon>&nbsp;Set Discounted Amount</strong></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-9">
              <input type="text" class="form-control form-control-sm" id="text_discount" placeholder="Discounted Amount">
            </div>
            <div class="col-sm-2">
              <button class="btn btn-sm btn-primary" id="btn_enter_discounted_amount">Enter</button>
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
