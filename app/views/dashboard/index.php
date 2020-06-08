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
        <h1 class="m-0 text-dark ml-2"><strong><icon class="fas fa-tachometer-alt"></icon>&nbsp;Dashboard</strong></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>dashboard">Dashboard</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">      

      <div class="row">
        <div class="col-lg-3 col-6">
          
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $data['users']; ?></h3>

              <p>Registered User Accounts</p>
            </div>
            <div class="icon">
              <i class="fas fa-user"></i>
            </div>
            <a href="<?php echo ROOT; ?>user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $data['patients']; ?></h3>

              <p>Registered Patients</p>
            </div>
            <div class="icon">
              <i class="fas fa-user"></i>
            </div>
            <a href="<?php echo ROOT; ?>patient" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo $data['products']; ?></h3>

              <p>Registered Dental Products</p>
            </div>
            <div class="icon">
              <i class="fas fa-syringe"></i>
            </div>
            <a href="<?php echo ROOT; ?>product" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-6">
          
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php echo $data['balances']; ?></h3>

              <p>Patients with Balance</p>
            </div>
            <div class="icon">
              <i class="fas fa-money-bill"></i>
            </div>
            <a href="<?php echo ROOT; ?>report" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
      </div>

      <div class="row-fluid">

        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-area mr-1"></i>
                Number of Clinic Visitors Per Month
              </h3>
            </div>
            <div class="card-body">
              <canvas id="visitors-chart-canvas" style="height:300px"></canvas>
            </div>
          </div>
        </div>

        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-area mr-1"></i>
                Collections Per Month
              </h3>
            </div>
            <div class="card-body">
              <canvas id="collections-chart-canvas" style="height:300px"></canvas>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>