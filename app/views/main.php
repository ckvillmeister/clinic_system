<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <!--<meta charset="utf-8">-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?php echo $data['system_name']; ?></title>

  <link rel="icon" type="image/png" href="<?php echo ROOT; ?>public/image/Clinic_Logo.png" sizes="96x96">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>
  <?php
    $page = (object) $data;
    if ($page->content != ''){
      require 'app/views/'.$page->content;
    }
  ?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  <?php require 'app/views/components/footer.php'; ?>
</div>

<div class="modal fade" id="modal_message_box" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
      </div>
      <div class="modal-body">
        <h6 class="modal-body" id="modal_body"></h6>
      </div>
      <div class="modal-footer">
    
      </div>
    </div>
  </div>
</div>

<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/adminlte.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/demo.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/raphael/raphael.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/pages/dashboard2.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<?php
  $url = $_GET['url'];
  $arr_url = explode('/', rtrim($url, '/'));
  $link = rtrim($arr_url[0], '/');

  if (count($arr_url) > 1){
    $link_2 = rtrim($arr_url[1], '/');
  }

  if ($link == 'dashboard'){
    echo '<script src="'.ROOT.'public/js/dashboard.js"></script>';
    echo '<script src="'.ROOT.'public/bootstrap/plugins/chart.js/Chart.min.js"></script>';
  }
  elseif ($link == 'patient'){
    echo '<script src="'.ROOT.'public/js/patient.js"></script>';
  }
  elseif ($link == 'transaction'){
    echo '<script src="'.ROOT.'public/js/transaction.js"></script>';
  }
  elseif ($link == 'payment'){
    echo '<script src="'.ROOT.'public/js/payment.js"></script>';
  }
  elseif ($link == 'service'){
    echo '<script src="'.ROOT.'public/js/service.js"></script>';
  }
  elseif ($link == 'report'){
    echo '<script src="'.ROOT.'public/js/report.js"></script>';
    echo '<script src="'.ROOT.'public/plugins/export_to_excel/src/jquery.table2excel.js"></script>';
  }
  elseif ($link == 'product'){
    echo '<script src="'.ROOT.'public/js/product.js"></script>';
  }
  elseif ($link == 'accessrole'){
    echo '<script src="'.ROOT.'public/js/role.js"></script>';
  }
  elseif ($link == 'user'){
    echo '<script src="'.ROOT.'public/js/user.js"></script>';
  }
  elseif ($link_2 == 'user_profile'){
    echo '<script src="'.ROOT.'public/js/user.js"></script>';
  }
  elseif ($link == 'settings'){
    echo '<script src="'.ROOT.'public/js/setting.js"></script>';
  }
  
?>
</body>
</html>
