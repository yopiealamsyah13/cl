<?php 
    $baris = $data->row();
?>
<section class="content-header">
  <h1>UPDATE USER INFORMATION</h1>
</section>
<section class="content">
        <div class="box box-primary">
        <div class="box-body">
        <form name="form-validate" id="adduser" class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url(); ?>/user_list/update/<?php echo $baris->user_id; ?>">
                
                    <div class="form-group form-group-sm">
                          <label for="name" class="col-sm-2 control-label">User Name</label>
                          <div class="col-sm-7">
                          <input type="text" class="form-control" name="name" value="<?php echo $baris->name_user; ?>" placeholder="Enter User Name">
                          </div>
                    </div>
                    <span class="help-block"> <?php echo form_error('name'); ?> </span>
                    
                    <div id="company">
                    <div class="form-group form-group-sm">
                    <label for="id_company" class="col-sm-2 control-label">Company</label>
                    <div class="col-sm-7">
                    <select class="form-control" name="id_company" id="id_company">
                        <option value="">Pilih Company</option>
                        <?php foreach ($option_company->result() as $valtype) {
                        if($baris->id_company==$valtype->id_company){
                        ?>
                        <option value="<?php echo $valtype->id_company; ?>" selected><?php echo $valtype->name_company; ?></option>
                        <?php }else{ ?>
                        <option value="<?php echo $valtype->id_company; ?>"><?php echo $valtype->name_company; ?></option>
                        <?php }} ?>
                    </select>
                    </div>
                    </div>
                    <span class="help-block"> <?php echo form_error('company'); ?></span>
                    </div>

    <div id="area_update">
        <div class="form-group form-group-sm">
        <label for="id_area" class="col-sm-2 control-label">Area</label>
            <div class="col-sm-7">
            <select class="form-control" name="id_area">
                        <option value="">Pilih Area</option>
                        <?php foreach ($area->result() as $valarea) {
                        if($baris->id_area==$valarea->id_area){
                        ?>
                        <option value="<?php echo $valarea->id_area; ?>" selected><?php echo $valarea->name_area; ?></option>
                        <?php }}?>
                    </select>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#id_company").change(function()
        {
            var id_company = {id_company:$("#id_company").val()
        };
            $.ajax(
            {
                type: "POST",
                url : "<?php echo site_url('user_list/select_area')?>",
                data: id_company,
                success: function(msg)
                {
                    $('#area_update').html(msg);
                }
            });
        });
    </script>

                    <div class="form-group form-group-sm">
                    <label for="role" class="col-sm-2 control-label">User Role</label>
                    <div class="col-sm-7">
                    <select class="form-control" name="role" id="role">
                        <option value="">Pilih User Role</option>
                        <?php foreach ($role->result() as $valrole) {
                        if($baris->role_id==$valrole->id){
                        ?>
                        <option value="<?php echo $valrole->id; ?>" selected><?php echo $valrole->name_role; ?></option>
                        <?php }else{ ?>
                        <option value="<?php echo $valrole->id; ?>"><?php echo $valrole->name_role; ?></option>
                        <?php }} ?>
                    </select>
                    </div>
                    </div>
                    <span class="help-block"> <?php echo form_error('role'); ?></span>

                    <div class="form-group form-group-sm">
                          <label for="email" class="col-sm-2 control-label">Email Address</label>
                          <div class="col-sm-7">
                          <input type="text" class="form-control" name="email" value="<?php echo $baris->email; ?>" placeholder="Enter Email Address">
                          </div>
                    </div>
                    <span class="help-block"> <?php echo form_error('email'); ?> </span>

                    <div class="form-group form-group-sm">
                          <label for="phone" class="col-sm-2 control-label">Phone</label>
                          <div class="col-sm-7">
                          <input type="text" class="form-control" name="phone" value="<?php echo $baris->phone; ?>" placeholder="Enter Phone Number">
                          </div>
                    </div>
                    <span class="help-block"> <?php echo form_error('phone'); ?> </span>

                    <div class="form-group form-group-sm">
                          <label for="mobile_phone" class="col-sm-2 control-label">Mobile Phone</label>
                          <div class="col-sm-7">
                          <input type="text" class="form-control" name="mobile_phone" value="<?php echo $baris->mobile_phone; ?>" placeholder="Enter Email Address">
                          </div>
                    </div>
                    <span class="help-block"> <?php echo form_error('mobile_phone'); ?> </span>
                </div>

                <div class="box-footer">
                  <button type="submit" class="btn btn-xs btn-primary" id="save">Submit</button>
                  <button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo site_url() ?>/user_list'; return false;">Cancel</button>
                </div>
        </form>
        </div>
        </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
    $('#adduser').validate({
      rules: {
        name: {
          required: true
        },
        id_company: {
          required: true
        },
        id_area: {
          required: true
        },
        role: {
          required: true
        },
        email: {
          required: true
        },
        password: {
          required: true
        },
        mobile_phone: {
          required: true
        }
      },
      messages: {
        name: "input name",
        id_company: "select company",
        id_area: "select area",
        role: "select role",
        email: "input email",
        password: "input password",
        mobile_phone: "input mobile phone"
      },
      submitHandler : function(form){
        $("#save").prop('disabled',true);
        $("#save").text('in progress');
        form.submit();
      }
    });
  });
</script>    
        