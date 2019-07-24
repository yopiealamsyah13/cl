<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CL</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CREDIT LIMIT</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu" id="show">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" id="totalnotif"></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu" id="tampil_notif">
                <!-- display notif ajax -->
                </ul>
              </li>
              <li class="footer"><a href="<?php echo site_url('notification'); ?>">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url(); ?>assets/photo/<?php echo $this->acl->get_user()->photo;?>" class="user-image">
              <span class="hidden-xs"><?php echo $this->acl->get_user()->name_user;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url(); ?>assets/photo/<?php echo $this->acl->get_user()->photo;?>" class="img-circle">

                <p>
                  <?php echo $this->acl->get_user()->name_user;?>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo site_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>

<script type="text/javascript">
  $(document).ready(function() {
    $.ajaxSetup({ cache: false });
    setInterval(function() {
      $('#totalnotif').load('<?php echo site_url() ?>/request/total_notification');
    }, 3000);
  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $.ajaxSetup({ cache: false });
    setInterval(function() {
      $('#tampil_notif').load('<?php echo site_url() ?>/request/notification');
    }, 3000);
  });
</script>