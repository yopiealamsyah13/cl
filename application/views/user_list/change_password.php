<?php
  $baris = $user->row();
?>

<section class="content-header">
  <h1>CHANGE PASSWORD</h1>
</section>
<section class="content">
  <div class="box box-primary">
  <div class="box-body">
        <div class="row">
          <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4 col-sm-4 col-sm-offset-4">
            <form class="form-validate" method="post" action="<?php echo site_url(); ?>/user_list/change_password/<?php echo $baris->id;?>">
              <input type="password" name="current_pass" class="form-control" placeholder="Current Password">
              <span class="help-block"> <?php echo form_error('current_pass'); ?> </span>
              <input type="password" name="new_pass" class="form-control" placeholder="New Password">
              <span class="help-block"> <?php echo form_error('new_pass'); ?> </span>
              <input type="password" name="confirm_pass" class="form-control" placeholder="Confirm New Password">
              <span class="help-block"> <?php echo form_error('confirm_pass'); ?> </span>
              <button class="btn btn-md btn-primary btn-block" type="submit">Submit</button>
            </form>
          </div>
        </div>
      </div>
      </div>
</section>