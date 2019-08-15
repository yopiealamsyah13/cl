<style>
  .img-circle{
    cursor:pointer;
  }

  .img-circle:hover{
    box-shadow: 0 0 2px 1px rgba(120, 140, 186, 0.5);
    opacity: 0.5;
  }
</style>

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
                <img src="<?php echo base_url(); ?>assets/photo/<?php echo $this->acl->get_user()->photo;?>" id="picture" class="img-circle">
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

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Change Profile Picture</h4>
        </div>
        <form method="post" action="<?php echo site_url('welcome/change_picture'); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-3">
                <input name="old" type="hidden" value="<?php echo $this->acl->get_user()->photo;?>">
                <img id="blah" src="<?php echo base_url(); ?>assets/photo/<?php echo $this->acl->get_user()->photo;?>" alt="your image" height="100" width="100" style="border:1px solid #ddd;" />
              </div>
              <div class="col-md-9">
                <label for="exampleInputFile">Choose File</label>
                <input type="file" id="exampleInputFile" class="form-control" name="file_upload">
                <p class="help-block">*Only allow format .jpg / .jpeg / .png</p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

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


<script>
  $(document).ready(function(){
    $('#picture').on('click',function(){
      $('#modal-default').modal('toggle');
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#blah').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#exampleInputFile").change(function() {
      readURL(this);
    });

  })
  </script>