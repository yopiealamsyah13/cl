<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({ cache: false });
        setInterval(function() {
            $('#totalrequest').load('<?php echo site_url() ?>/request/total_request');
        }, 1000);
    });
</script>

<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  <div class="navbar-brand"><?php echo "CREDIT LIMIT CONTROLLER"; ?></div>
</div>

  <?php
    $user_list = $this->acl->get_user_permissions()->user_list;
    $user_role = $this->acl->get_user_permissions()->user_role;
  ?>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
      <li><a href="<?php echo site_url('request'); ?>">Request <span id="totalrequest"></span></a></li>

      <li class="dropdown">
      <?php if($user_list=='1' or $user_role=='1'){ ?>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> User <b class="caret"></b></a>
        <?php }?>
        <ul class="dropdown-menu">
          <?php if($user_list=='1'){ ?>
          <li><a href="<?php echo site_url('user_list'); ?>"><i class="fa fa-list"></i> User List</a></li>
          <?php }?>
          <?php if($user_role=='1'){ ?>
          <li><a href="<?php echo site_url('user_role'); ?>"><i class="fa fa-list"></i> User Role</a></li>
          <?php }?>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->acl->get_user()->name_user;?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo site_url('logout'); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>