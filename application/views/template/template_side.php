<?php
  $user_list = $this->acl->get_user_permissions()->user_list;
  $user_role = $this->acl->get_user_permissions()->user_role;
  $customer = $this->acl->get_user_permissions()->customer;
  $request = $this->acl->get_user_permissions()->request;
  $outstanding = $this->acl->get_user_permissions()->outstanding;
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar main-sidebar-sfs">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar navbar-sfs">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assets/photo/<?php if($this->acl->get_user()->photo!=''){echo $this->acl->get_user()->photo;}else{echo "blank.jpg";}?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
	     <?php
		echo substr($this->acl->get_user()->name_user, 0, 18);
               	if(strlen($this->acl->get_user()->name_user) > 18)
		{
               	  echo '...';
                }
             ?>
	  </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <?php if($customer=='1'){ ?>
      <!-- search form -->
      <form class="sidebar-form" action="<?php echo site_url() ?>/customer" method="GET">
        <div class="input-group">
          <input type="text" name="term" class="form-control" placeholder="Search Customer" autocomplete="off">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-flat"><span class="fa fa-search"></span></button>
          </span>
        </div>
      </form>
      <?php } ?>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu sidebar-menu-sfs" data-widget="tree">
        <li class="header">MAIN MENU</li>
        <li>
          <a href="<?php echo site_url('welcome'); ?>">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
        <?php
          if($request=='1'){
        ?>
        <li>
          <a href="<?php echo site_url('request'); ?>">
            <i class="fa fa-tasks"></i> <span>Credit Limit Request</span>
            <span class="pull-right-container">
              <span id="totalrequest"></span>
            </span>
          </a>
        </li>
        <li>
          <a href="<?php echo site_url('request/history'); ?>">
            <i class="fa fa-list"></i> <span>History</span>
          </a>
        </li>
        <?php } ?>
         <?php if($customer=='1'){ ?>
        <li class="header">MASTER DATA</li>
        <li>
          <a href="<?php echo site_url('customer'); ?>">
            <i class="fa fa-users"></i> <span>Customer</span>
          </a>
        </li>
        <?php } ?>
        <?php if($user_list=='1' or $user_role=='1'){ ?>
        <li class="header">SETTING</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>User Setting</span>
            <span class="pull-right-container bg-sefas">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php }?>
          <ul class="treeview-menu">
            <?php if($user_list=='1'){ ?>
            <li><a href="<?php echo site_url('user_list'); ?>"><i class="fa fa-circle-o"></i> User List</a></li>
            <?php }?>
            <?php if($user_role=='1'){ ?>
            <li><a href="<?php echo site_url('user_role'); ?>"><i class="fa fa-circle-o"></i> User Role</a></li>
            <?php }?>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({ cache: false });
        setInterval(function() {
            $('#totalrequest').load('<?php echo site_url() ?>/request/total_pending_notif');
        }, 3000);
    });
</script>
