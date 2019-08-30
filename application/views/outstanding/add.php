<section class="content-header">
  <h1>ADD OUTSTANDING AR</h1>
</section>
<section class="content">
<div class="box box-primary">
        <form name="form-validate" id="addreq" enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo site_url(); ?>/outstanding/add_outstanding">
        <div class="box-body">

          <div class="form-group form-group-sm">
            <label for="id_customer" class="col-sm-2 control-label">Customer :</label>
            <div class="col-sm-4">
              <select class="form-control select2" name="id_customer" style="width: 100%;">
                <option value="">-- Select --</option>
                <?php foreach ($customer->result() as $rowc) {?>
                <option value="<?php echo $rowc->id_customer; ?>"><?php echo strtoupper($rowc->name_customer); ?> - <?php echo $rowc->name_user;?></option>
                <?php } ?>
              </select>
            </div>   
          </div>
          <span class="help-block"><?php echo form_error('id_customer');?></span>

          <div class="form-group form-group-sm">
            <label for="po_number" class="col-sm-2 control-label">PO No. :</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="po_number" placeholder="Input PO Number" autocomplete="off">
              </div>
          </div>
          <span class="help-block"><?php echo form_error('po_number');?></span>

          <div class="form-group form-group-sm">
            <label for="invoice_no" class="col-sm-2 control-label">Invoice No. :</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="invoice_no" placeholder="Input Invoice Number" autocomplete="off">
              </div>
          </div>
          <span class="help-block"><?php echo form_error('invoice_no');?></span>

          <div class="form-group form-group-sm">
            <label for="invoice_date" class="col-sm-2 control-label">Invoice Date :</label>
              <div class="col-sm-4">
                <input id="datepicker1" type="text" name="invoice_date" class="form-control" placeholder="Select Invoice Date" required autocomplete='off'>
              </div>
          </div>
          <span class="help-block"><?php echo form_error('invoice_date');?></span>

          <div class="form-group form-group-sm">
            <label for="receive_date" class="col-sm-2 control-label">Receive Date :</label>
              <div class="col-sm-4">
                <input id="datepicker2" type="text" name="receive_date" class="form-control" placeholder="Select Receive Date" required autocomplete='off'>
              </div>
          </div>
          <span class="help-block"><?php echo form_error('receive_date');?></span>

          <div class="form-group form-group-sm">
            <label for="invoice_amount" class="col-sm-2 control-label">Invoice Amount :</label>
              <div class="col-sm-4">
                <input data-a-dec="," data-a-sep="." type="text" class="invoice_amount form-control" name="invoice_amount" placeholder="Input Amount" autocomplete="off">
              </div>
          </div>
          <span class="help-block"><?php echo form_error('invoice_amount');?></span>

          <div class="form-group form-group-sm">
            <label for="remark" class="col-sm-2 control-label">Remark :</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="remark" placeholder="Input Remark" autocomplete="off">
              </div>
          </div>
          <span class="help-block"><?php echo form_error('remark');?></span>

        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-xs btn-primary" id="save">Submit</button>
          <button type="button" class="btn btn-xs btn-danger" onclick="window.location.href='<?php echo site_url() ?>/outstanding'; return false;">Cancel</button>
        </div>
        </form>
  </div>
</section>

<script type="text/javascript">
  $('.invoice_amount').autoNumeric();
</script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<script>
$(function() {
  $("#datepicker1").datepicker(
  {
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    orientation: 'bottom'
  });
  $("#datepicker2").datepicker(
  {
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    orientation: 'bottom'
  });
});
</script>