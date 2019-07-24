<div class="form-group form-group-sm">
<label for="name" class="col-sm-2 control-label">Area</label>
<div class="col-sm-7">

<select class="form-control" name="id_area">
<option value="">Pilih Area</option>
<?php foreach ($option_area->result() as $valtype){?>
    <option value="<?php echo $valtype->id_area; ?>"><?php echo $valtype->name_area; ?></option><?php } ?>
</select>
</div>
</div>
<span class="help-block"><?php echo form_error('id_area'); ?></span>