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
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
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
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="<?php echo $image; ?>">
              </div>

              <h3 class="profile-username text-center"><?php echo trim($patient_info->firstname).' '.trim($patient_info->middlename).' '.trim($patient_info->lastname).' '.trim($patient_info->extension); ?></h3>     
              <p class="text-muted text-center"><?php echo 'Patient ID: '.$patient_info->patientid; ?></p>         

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Number of Visits</b> <a class="float-right"></a>
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
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#patient_history" data-toggle="tab">Patient History</a></li>
                  <li class="nav-item"><a class="nav-link" href="#payment_history" data-toggle="tab">Payment History</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="patient_history">
                    <div class="overlay-wrapper">
      
                    </div>
                  </div>
                  <div class="tab-pane" id="payment_history">
                    <div class="overlay-wrapper">
      
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