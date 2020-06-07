<?php
$patient_info = (object) $data['patient_info'];
$image = ($patient_info->sex == 'MALE') ? ROOT.'public/image/avatar100x100.jpg' : ROOT.'public/image/avatar_f_250x250.png';
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-id-card-alt"></icon>&nbsp;Patient Profile</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>patient">Patient Records</a></li>
            <li class="breadcrumb-item active">Patient Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-5">
          <div class="card card-primary card-outline" id="card_1">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="<?php echo $image; ?>">
              </div>

              <h3 class="profile-username text-center"><?php echo trim($patient_info->firstname).' '.trim($patient_info->middlename).' '.trim($patient_info->lastname).' '.trim($patient_info->extension); ?></h3>     
              <p class="text-muted text-center"><?php echo 'Patient ID: '.$patient_info->patientid; ?></p>         

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Number of Visits</b> <a class="float-right"><?php echo $data['no_of_visits']; ?></a>
                </li>
              </ul>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item bg-primary text-center">
                    <h5>Information</h5>
                </li>
              </ul>

              <strong><i class="fas fa-venus-mars mr-1"></i>Sex</strong>
              <p class="text-muted"><?php echo ucfirst(strtolower($patient_info->sex)); ?></p>

              <strong><i class="fas fa-map-marker-alt mr-1"></i>Address</strong>
              <p class="text-muted">
                <?php 
                  $purok = ($patient_info->address_purok) ? 'Purok '.$patient_info->address_purok.', ' : '';
                  echo ucwords(mb_strtolower($purok.$patient_info->address_brgy.', '.$patient_info->address_citymun.', BOHOL')); ?>
              </p>
              <strong><i class="fas fa-birthday-cake mr-1"></i>Birthdate</strong>
              <p class="text-muted"><?php 
                $date = strval($patient_info->birthdate);

                if ($date != '0000-00-00'){
                  $date = date_create($patient_info->birthdate);
                  echo date_format($date, "F d, Y");
                }
              ?>
              </p>

              <strong><i class="fas fa-phone mr-1"></i>Contact Number</strong>
              <p class="text-muted"><?php echo $patient_info->contact_number; ?></p>

              <strong><i class="fas fa-envelope mr-1"></i>Email</strong>
              <p class="text-muted"><?php echo $patient_info->email; ?></p>

            </div>
          </div>
        </div>
        <div class="col-sm-7">
            <div class="card card-primary card-outline" id="card_2">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#medical_history" data-toggle="tab">Medical History Remarks</a></li>
                  <li class="nav-item"><a class="nav-link" href="#patient_history" data-toggle="tab">Availed Services History</a></li>
                  <li class="nav-item"><a class="nav-link" href="#payment_history" data-toggle="tab">Payment History</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="medical_history">
                    <textarea id="text_medical_history_remarks" rows="4" style="resize:none; font-size: 16pt" class="form-control form-control-sm bg-white" readonly="readonly"><?php echo $patient_info->remarks; ?></textarea>

                  </div>
                  <div class="tab-pane" id="patient_history">
                    <div class="overlay-wrapper"></div>
                    <table class="table table-striped" id="table_summary">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Service</th>
                          <th>Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $ctr = 0;

                          if ($data['services_availed'] != 0){

                          foreach ($data['services_availed'] as $key => $service) {
                            $service_detail = (object) $service;
                        ?>
                        <tr>
                          <td><?php echo ++$ctr; ?></td>
                          <td><?php echo $service_detail->name; ?></td>
                          <td style="white-space: pre-line;"><?php echo $service_detail->remarks; ?></td>
                        </tr>
                        <?php
                          }

                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="payment_history">
                    <div class="overlay-wrapper"></div>
                    <table class="table table-striped" id="table_summary">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Transaction ID</th>
                          <th>Balance</th>
                          <th>Amount Paid</th>
                          <th>Change</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $prev_transaction_id = '';
                          $balance = 0;
                          $ctr = 0;

                          if ($data['payment_history'] != 0){

                          foreach ($data['payment_history'] as $key => $payment) {
                            $payment_detail = (object) $payment;

                            if ($prev_transaction_id != $payment_detail->transaction_id){
                              if ($payment_detail->discounted_amount == 0 | $payment_detail->transaction_id == ''){
                                $balance = $payment_detail->total_amount;
                              }
                              else{
                                $balance = $payment_detail->discounted_amount;
                              }
                            }

                            $prev_transaction_id = $payment_detail->transaction_id;
                        ?>
                        <tr>
                          <td><?php echo ++$ctr; ?></td>
                          <td><?php echo $payment_detail->transaction_id; ?></td>
                          <td><?php echo number_format($balance, 2); ?></td>
                          <td><?php echo number_format($payment_detail->amount_tendered, 2); ?></td>
                          <td>
                            <?php
                              if (($payment_detail->amount_tendered - $balance) < 0){
                                echo number_format(0, 2);
                              }
                              else{
                                echo number_format(($payment_detail->amount_tendered - $balance), 2);
                              }
                            ?>
                          </td>
                        </tr>
                        <?php
                          $balance -= $payment_detail->amount_tendered;
                          }

                          }
                        ?>
                      </tbody>
                    </table>
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