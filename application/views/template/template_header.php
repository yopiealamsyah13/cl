<style>
  .user-header:hover .caption-imgc {
    visibility: visible;
    opacity: 2;
  }

  .caption-imgc{
    color:#333;
    position:absolute;
    top: 55px;
    bottom: 120px;
    border-bottom-left-radius: 100px;
    border-bottom-right-radius:100px;
    left: 98px;
    right: 98px;
    visibility: hidden;
    opacity: 0;
    background-color:rgba(0, 0, 0, 0.6);
    cursor:pointer;
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
                    <img src="<?php echo base_url(); ?>assets/photo/<?php echo $this->acl->get_user()->photo;?>" class="img-circle">
                  <p class="caption-imgc" id="change"><small>Change</small></p>
                  <p>
                    <?php echo $this->acl->get_user()->name_user;?>
                  </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('user_list/change_password'); ?>" class="btn btn-default btn-flat">Change Password</a>
                </div>
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

  <div class="modal fade" tab-index="-1" id="modal-default" aria-hidden="true" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Change Profile Picture</h4>
        </div>
        <form method="post" action="<?php echo site_url('welcome/change_picture'); ?>" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div id="jcrop"></div>
                <input name="old" type="hidden" value="<?php echo $this->acl->get_user()->photo;?>" style="display:none;">
              </div>
              <div class="col-md-12">
                <label for="exampleInputFile">Choose File</label>
                <input type="file" id="exampleInputFile" class="form-control" name="file_upload">
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <p class="help-block">*Only allow format .jpg / .jpeg / .png</p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
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

    $('#change').on('click',function(){
      $('#modal-default').modal('toggle');
    });

    var picture_width;
    var picture_height;
    var crop_max_width = 354;
    var crop_max_height = 354;

    $("#exampleInputFile").change(function() {
      readURL(this);
    });

    
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $("#jcrop, #preview").html("").append("<img src=\""+e.target.result+"\" alt=\"\" />");
          picture_width = $("#preview img").width();
          picture_height = $("#preview img").height();
          $("#jcrop  img").Jcrop({
            onSelect: updateCoords,
            onChange: updateCoords,
            boxWidth: crop_max_width,
            boxHeight: crop_max_height,
            setSelect: [100,100,354,354],
            aspectRatio : 1
          });
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    function updateCoords(c)
    {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
    }

  </script>