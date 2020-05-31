<!DOCTYPE html>
<html>

<head>
  <title>Clinic System</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-light" style="background-color: #000080">
    <div class="container">
      
      <a href="<?php echo ROOT; ?>" class="navbar-brand">
        <img src="<?php echo ROOT; ?>public/image/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light" style="color:white">Dental Clinic</span>
      </a>
      
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="mr-3">
          <input class="form-control form-control-navbar" type="text" id="text_username" placeholder="Username" aria-label="Search">
        </li>
        <li class="mr-3">
          <input class="form-control form-control-navbar" type="password" id="text_password" placeholder="Password" aria-label="Search">
        </li>
        <li>
           <button class="btn btn-navbar" type="submit" id="btn_login"><i class="fas fa-sign-in-alt"></i></button>
        </li>
      </ul>
    </div>
  </nav>
</div>  

<div class="modal fade" id="modal_message_box" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
      </div>
      <div class="modal-body">
        <h6 class="modal-body" id="modal_body"></h5>
      </div>
      <div class="modal-footer">
    
      </div>
    </div>
  </div>
</div>

<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/adminlte.min.js"></script>
<script src="<?php echo ROOT; ?>public/js/authentication.js"></script>
</body>

</html>