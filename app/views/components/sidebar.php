<?php
  $url = $_GET['url'];
  $arr_url = explode('/', rtrim($url, '/'));
  $link = rtrim($arr_url[0], '/');
  $link_2 = "";

  if (count($arr_url) > 1){
     $link_2 = ltrim($arr_url[1], '/');
  }

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->

  <a href="<?php echo ROOT; ?>main" class="brand-link">
    <img src="<?php echo ROOT; ?>public/image/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 mr-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Dental Clinic</span>
  </a>

  <div class="sidebar">
    <div class="mt-3 mb-3 d-flex">
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>dashboard" class="nav-link <?php echo ($link == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>patient" class="nav-link <?php echo ($link == 'patient') ? 'active' : ''; ?>">
            <i class="nav-icon fas fas fa-users"></i>
            <p>
              Patient Records
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>transaction" class="nav-link <?php echo ($link == 'transaction') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-hand-holding-medical"></i>
            <p>
              Services Transaction
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>payment" class="nav-link <?php echo ($link == 'payment') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-money-bill-wave"></i>
            <p>
              Payment
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>report" class="nav-link <?php echo ($link == 'report') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-list"></i>
            <p>
              Reports
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview <?php if ($link == 'service' | $link == 'product' | $link=='accessrole' | $link=='user' | $link=='settings'){ echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if ($link == 'service' | $link == 'product' | $link=='accessrole' | $link=='user' | $link=='settings'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Maintenance
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>product" class="nav-link <?php echo ($link == 'product') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Dental Products</p>
              </a>
            </li>
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>service" class="nav-link <?php echo ($link == 'service') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Services Management</p>
              </a>
            </li>
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>accessrole" class="nav-link <?php echo ($link == 'accessrole') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Access Roles</p>
              </a>
            </li>
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>user" class="nav-link <?php echo ($link == 'user') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>User Accounts</p>
              </a>
            </li>
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>settings" class="nav-link <?php echo ($link == 'settings') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>System Settings</p>
              </a>
            </li>
          </ul>
        </li>
        
    </nav>
  </div>
</aside>