<?php
  $firstname = '';
  $middlename = '';
  $lastname = '';

  if (isset($_SESSION['firstname']) & isset($_SESSION['middlename']) & isset($_SESSION['lastname'])){
    $firstname = $_SESSION['firstname'];
    $middlename = $_SESSION['middlename'];
    $lastname = $_SESSION['lastname'];
  }
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
   
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img class="img-circle elevation-1" src="<?php echo ROOT; ?>public/image/silhouette25x25.png">
        <b></b>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="<?php echo ROOT; ?>public/image/silhouette100x100.png">
            </div>
            <h3 class="profile-username text-center"><?php echo strtoupper($firstname.' '.$lastname); ?></h3>
          </div>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-id-badge ml-3 mr-3"></i> Profile
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-key ml-3 mr-3"></i> Change Password
          </a>
          <a href="authentication/logout" class="dropdown-item">
            <i class="fas fa-sign-out-alt ml-3 mr-3"></i> Logout
          </a>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
          class="fas fa-th-large"></i></a>
    </li>
  </ul>
</nav>