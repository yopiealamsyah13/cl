<?php
  $user_list = $this->acl->get_user_permissions()->user_list;
  $user_role = $this->acl->get_user_permissions()->user_role;
  $customer = $this->acl->get_user_permissions()->customer;
  $id_role = $this->session->userdata('id_role');
?>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>assets/photo/<?php echo $this->acl->get_user()->photo;?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->acl->get_user()->name_user;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN MENU</li>
        <li>
          <a href="<?php echo site_url('welcome'); ?>">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
        <?php if($id_role != '11'){?>
        <li>
          <a href="<?php echo site_url('request'); ?>">
            <i class="fa fa-tasks"></i> <span>Credit Limit Request</span>
            <span class="pull-right-container">
              <span id="totalrequest"></span>
            </span>
          </a>
        </li>
        <?php }?>
        <li>
          <a href="<?php echo site_url('request/history'); ?>">
            <i class="fa fa-list"></i> <span>History</span>
          </a>
        </li>
        <li>
          <a href="<?php echo site_url('feeds'); ?>">
            <i class="fa fa-info"></i> <span>Feeds</span>
          </a>
        </li>
        <?php if($customer=='1'){ ?>
        <li class="header">DATA</li>
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
            <span class="pull-right-container">
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
            $('#totalrequest').load('<?php echo site_url() ?>/request/total_pending');
        }, 1000);
    });
</script>